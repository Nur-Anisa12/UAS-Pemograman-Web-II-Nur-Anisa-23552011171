<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ── Filter helper biar tidak duplikat kode ──
    private function getQuery(Request $request)
    {
        $query = Booking::with(['tamu', 'kamar.tipeKamar'])->latest();

        if ($request->dari) {
            $query->whereDate('check_in_date', '>=', $request->dari);
        }
        if ($request->sampai) {
            $query->whereDate('check_in_date', '<=', $request->sampai);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->tipe_kamar_id) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('tipe_kamar_id', $request->tipe_kamar_id);
            });
        }

        return $query;
    }

    // ── Halaman utama laporan ──
    public function index(Request $request)
    {
        $bookings   = $this->getQuery($request)->paginate(15)->withQueryString();
        $tipeKamars = TipeKamar::all();

        // Statistik — ambil semua data tanpa pagination untuk hitung total
        $allData = $this->getQuery($request)->get();

        $stats = [
            'total'      => $allData->count(),
            'pendapatan' => $allData->where('status', 'checked_out')->sum('total_harga'),
            'menginap'   => $allData->where('status', 'checked_in')->count(),
            'cancelled'  => $allData->where('status', 'cancelled')->count(),
        ];

        return view('laporan.index', compact('bookings', 'tipeKamars', 'stats'));
    }

    // ── Export Excel ──
    public function exportExcel(Request $request)
    {
        $bookings = $this->getQuery($request)->get();
        $no = 0;
        $filename = 'laporan-reservasi-' . now()->format('d-m-Y') . '.xlsx';

        return (new FastExcel($bookings))->download($filename, function ($booking) use (&$no) {
            $no++;
            return [
                'No'            => $no,
                'ID Booking'    => $booking->id,
                'Nama Tamu'     => $booking->tamu->nama_lengkap,
                'No. Identitas' => $booking->tamu->identity_number,
                'Nomor Kamar'   => $booking->kamar->nomor_kamar,
                'Tipe Kamar'    => $booking->kamar->tipeKamar->nama_tipe_kamar,
                'Check-In'      => $booking->check_in_date,
                'Check-Out'     => $booking->check_out_date,
                'Total Malam'   => $booking->total_malam,
                'Total Harga'   => $booking->total_harga,
                'Status'        => strtoupper($booking->status),
                'Catatan'       => $booking->catatan ?? '-',
            ];
        });
    }

    // ── Export PDF ──
    public function exportPdf(Request $request)
    {
        $bookings = $this->getQuery($request)->get();
        $dari     = $request->dari;
        $sampai   = $request->sampai;
        $status   = $request->status;

        $pdf = Pdf::loadView('laporan.pdf', compact('bookings', 'dari', 'sampai', 'status'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan-reservasi-' . now()->format('d-m-Y') . '.pdf';

        return $pdf->stream($filename);
    }
}
