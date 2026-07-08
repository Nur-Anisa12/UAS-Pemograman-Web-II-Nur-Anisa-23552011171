<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $query = Booking::with(['tamu', 'kamar.tipeKamar'])
            ->where('status', 'confirmed')
            ->latest();

        // Search
        if ($request->search) {
            $query->whereHas('tamu', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('identity_number', 'like', '%' . $request->search . '%');
            })->orWhereHas('kamar', function ($q) use ($request) {
                $q->where('nomor_kamar', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->paginate(10)->withQueryString();

        // Statistik
        $stats = [
            'siap'      => Booking::where('status', 'confirmed')->count(),
            'hari_ini'  => Booking::where('status', 'confirmed')
                ->whereDate('check_in_date', $today)->count(),
            'terlambat' => Booking::where('status', 'confirmed')
                ->whereDate('check_in_date', '<', $today)->count(),
        ];

        return view('petugas.check-in.index', compact('bookings', 'stats', 'today'));
    }

    public function process(int $id)
    {
        $booking = Booking::where('id', $id)->firstOrFail();

        if ($booking->status !== 'confirmed') {
            return redirect()->back()
                ->with('error', 'Booking harus berstatus confirmed!');
        }

        $booking->update([
            'status'     => 'checked_in',
            'handled_by' => Auth::id(),
        ]);

        $booking->kamar->update(['status' => 'terisi']);

        ActivityLogger::log(
            action: 'checkin',
            module: 'booking',
            description: "Check-in tamu {$booking->tamu->nama_lengkap} di kamar {$booking->kamar->nomor_kamar}"
        );
        return redirect()->back()
            ->with('success', 'Check-In berhasil! Tamu ' .
                $booking->tamu->nama_lengkap .
                ' kamar ' . $booking->kamar->nomor_kamar . ' sudah masuk.');
    }
}
