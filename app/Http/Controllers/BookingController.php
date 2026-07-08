<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Tamu;
use App\Models\Kamar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query_search = Booking::with(['tamu', 'kamar.tipeKamar'])->latest();

        // Filter search
        if ($request->search) {
            $query_search->whereHas('tamu', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            })->orWhereHas('kamar', function ($q) use ($request) {
                $q->where('nomor_kamar', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->status) {
            $query_search->where('status', $request->status);
        }

        $bookings = $query_search->paginate(10)->withQueryString();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Tambah ini sementara untuk debug
    public function create()
    {
        // Hanya kamar available yang bisa dipilih
        $tamu = Tamu::orderBy('nama_lengkap')->get();
        $kamar = Kamar::with('tipeKamar')
            ->where('status', 'tersedia')
            ->get();
        return view('admin.bookings.create', compact('tamu', 'kamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tamu_id'       => 'required|exists:tamu,id',
            'kamar_id'        => 'required|exists:kamar,id',
            'check_in_date'  => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'catatan'          => 'nullable|string',
        ], [
            'tamu_id.required'       => 'Tamu wajib dipilih!',
            'kamar_id.required'        => 'Kamar wajib dipilih!',
            'check_in_date.required'  => 'Tanggal check-in wajib diisi!',
            'check_in_date.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini!',
            'check_out_date.required' => 'Tanggal check-out wajib diisi!',
            'check_out_date.after'    => 'Tanggal check-out harus setelah check-in!',
        ]);

        // Hitung otomatis total malam & harga
        $kamar        = Kamar::with('tipeKamar')->find($request->kamar_id);
        $checkIn     = Carbon::parse($request->check_in_date);
        $checkOut    = Carbon::parse($request->check_out_date);
        $totalMalam = $checkIn->diffInDays($checkOut);
        $totalHarga = $totalMalam * $kamar->tipeKamar->harga_per_malam;

        $Booking = Booking::create([
            'tamu_id'       => $request->tamu_id,
            'kamar_id'        => $request->kamar_id,
            'check_in_date'  => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_malam'   => $totalMalam,
            'total_harga'    => $totalHarga,
            'status'         => 'pending',
            'catatan'          => $request->catatan,
        ]);

        ActivityLogger::log(
            action: 'create',
            module: 'booking',
            description: "Membuat booking untuk tamu {$Booking->tamu->nama_lengkap}"
        );

        return redirect()->route(Auth::user()->role . '.bookings.index')
            ->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['tamu', 'kamar.tipeKamar']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Booking yang sudah check-in/out tidak bisa diedit
        if (in_array($booking->status, ['checked_in', 'checked_out'])) {
            return redirect()->back()
                ->with('error', 'Booking yang sudah check-in/out tidak bisa diedit!');
        }

        $tamuu = Tamu::orderBy('nama_lengkap')->get();
        $kamar  = Kamar::with('tipeKamar')
            ->where(function ($q) use ($booking) {
                $q->where('status', 'Tersedia')
                    ->orWhere('id', $booking->kamar_id);
            })->get();

        return view('admin.bookings.edit', compact('booking', 'tamuu', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'tamu_id'       => 'required|exists:tamu,id',
            'kamar_id'        => 'required|exists:kamar,id',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status'         => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
            'catatan'          => 'nullable|string',
        ]);

        // Hitung ulang total
        $kamar        = Kamar::with('tipeKamar')->find($request->kamar_id);
        $checkIn     = Carbon::parse($request->check_in_date);
        $checkOut    = Carbon::parse($request->check_out_date);
        $totalNights = $checkIn->diffInDays($checkOut);
        $totalPrice  = $totalNights * $kamar->tipeKamar->harga_per_malam;

        $booking->update([
            'tamu_id'       => $request->tamu_id,
            'kamar_id'        => $request->kamar_id,
            'check_in_date'  => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_malam'   => $totalNights,
            'total_harga'    => $totalPrice,
            'status'         => $request->status,
            'catatan'          => $request->catatan,
        ]);

        ActivityLogger::log(
            action: 'update',
            module: 'booking',
            description: "Mengubah booking {$booking->id}"
        );
        return redirect()->route(Auth::user()->role . '.bookings.index')
            ->with('success', 'Booking berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Simpan dulu sebelum dihapus
        $namaKamar = $booking->kamar->nomor_kamar;
        $namaTamu  = $booking->tamu->nama_lengkap;

        $booking->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'booking',
            description: "Menghapus booking tamu {$namaTamu} kamar {$namaKamar}"
        );

        return redirect()->route(Auth::user()->role . '.bookings.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    // ── PROSES CHECK-IN ──
    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return redirect()->back()
                ->with('error', 'Booking harus berstatus confirmed dulu!');
        }

        // Update status booking + status kamar
        $booking->update([
            'status'     => 'checked_in',
        ]);

        $booking->kamar->update(['status' => 'terisi']);

        ActivityLogger::log(
            action: 'check_in',
            module: 'booking',
            description: "Check In booking {$booking->id} kamar {$booking->kamar->nomor_kamar}"
        );

        return redirect()->back()
            ->with('success', 'Check-In berhasil! Kamar ' . $booking->kamar->nomor_kamar . ' sekarang terisi.');
    }

    // ── PROSES CHECK-OUT ──
    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return redirect()->back()
                ->with('error', 'Tamu harus sudah check-in dulu!');
        }

        // Update status booking + kamar kembali available
        $booking->update([
            'status'     => 'checked_out',
        ]);

        $booking->kamar->update(['status' => 'tersedia']);

        ActivityLogger::log(
            action: 'check_out',
            module: 'booking',
            description: "Check Out booking {$booking->id} kamar {$booking->kamar->nomor_kamar}"
        );
        return redirect()->back()
            ->with('success', 'Check-Out berhasil! Kamar ' . $booking->kamar->nomor_kamar . ' kembali tersedia.');
    }

    // ── KONFIRMASI BOOKING ──
    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya booking pending yang bisa dikonfirmasi!');
        }

        $booking->update(['status' => 'confirmed']);

        ActivityLogger::log(
            action: 'update',
            module: 'booking',
            description: "Konfirmasi booking #{$booking->id} tamu {$booking->tamu->nama_lengkap}"
        );

        return redirect()->back()
            ->with('success', 'Booking berhasil dikonfirmasi!');
    }

    // ── BATALKAN BOOKING ──
    public function cancel(Booking $booking)
    {
        if (in_array($booking->status, ['checked_in', 'checked_out'])) {
            return redirect()->back()
                ->with('error', 'Booking yang sudah check-in/out tidak bisa dibatalkan!');
        }

        $booking->update(['status' => 'cancelled']);

        // Kalau kamarnya occupied, kembalikan ke available
        if ($booking->kamar->status === 'terisi') {
            $booking->kamar->update(['status' => 'tersedia']);
        }

        ActivityLogger::log(
            action: 'cancel',
            module: 'booking',
            description: "Membatalkan booking #{$booking->id}"
        );

        return redirect()->back()
            ->with('success', 'Booking berhasil dibatalkan!');
    }
}
