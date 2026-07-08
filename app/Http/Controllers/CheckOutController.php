<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function index(Request $request)
    { 
        $today = Carbon::today();

            $query = Booking::with(['tamu', 'kamar.tipeKamar'])
                ->where(function ($q) use ($today) {
                    $q->where('status', 'checked_in')
                    ->orWhere(function ($q2) use ($today) {
                        $q2->where('status', 'checked_out')
                            ->whereDate('updated_at', $today); // hanya checked_out hari ini
                    });
                })
                ->latest();
        // Search
            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->whereHas('tamu', function ($q2) use ($request) {
                        $q2->where('nama_lengkap', 'like', '%' . $request->search . '%')
                        ->orWhere('identity_number', 'like', '%' . $request->search . '%');
                    })->orWhereHas('kamar', function ($q2) use ($request) {
                        $q2->where('nomor_kamar', 'like', '%' . $request->search . '%');
                    });
                });
            }

        $bookings = $query->paginate(10)->withQueryString();

        // Statistik
        $stats = [
            'menginap'  => Booking::where('status', 'checked_in')->count(),
            'hari_ini'  => Booking::where('status', 'checked_in')
                ->whereDate('check_out_date', $today)->count(),
            'terlambat' => Booking::where('status', 'checked_in')
                ->whereDate('check_out_date', '<', $today)->count(),
        ];

        return view('petugas.check-out.index', compact('bookings', 'stats', 'today'));
    }

    public function process(int $id)
    {
        $booking = Booking::where('id', $id)->firstOrFail();

        if ($booking->status !== 'checked_in') {
            return redirect()->back()
                ->with('error', 'Tamu harus sudah check-in dulu!');
        }

        $booking->update([
            'status'     => 'checked_out',
            'handled_by' => Auth::id(),
        ]);

        $booking->kamar->update(['status' => 'tersedia']);

            ActivityLogger::log(
            action: 'checkout',
            module: 'booking',
            description: "Check-out tamu {$booking->tamu->nama_lengkap} di kamar {$booking->kamar->nomor_kamar}"

        );
        return redirect()->back()
            ->with('success', 'Check-Out berhasil! Kamar ' .
                $booking->kamar->nomor_kamar .
                ' kembali tersedia.');
    }

    public function nota(int $id)
    {
        $booking = Booking::with(['tamu', 'kamar.tipeKamar'])->where('id', $id)->firstOrFail();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('petugas.check-out.nota', compact('booking'))
                    ->setPaper('a5', 'portrait');

        $filename = 'nota-' . $booking->tamu->nama_lengkap . '-' . now()->format('d-m-Y') . '.pdf';

        return $pdf->stream($filename);
    }
}
