<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Services\ActivityLogger;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        // Hitung summary sekali, bukan query langsung di view
        $summary = [
            'semua'      => Kamar::count(),
            'tersedia'   => Kamar::where('status', 'tersedia')->count(),
            'terisi'     => Kamar::where('status', 'terisi')->count(),
            'perawatan'  => Kamar::where('status', 'perawatan')->count(),
        ];

        $kamar = Kamar::with('tipeKamar')
            ->when($search, function ($query, $search) {
                $query->where('nomor_kamar', 'like', "%{$search}%")
                    ->orWhereHas('tipeKamar', function ($q) use ($search) {
                        $q->where('nama_tipe_kamar', 'like', "%{$search}%");
                    });
            })
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kamar.index', compact('kamar', 'search', 'status', 'summary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeKamar = TipeKamar::all(); // untuk dropdown
        return view('admin.kamar.create', compact('tipeKamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
            'nomor_kamar'  => 'required|string|unique:kamar,nomor_kamar',
            'status'       => 'required|in:tersedia,terisi,perawatan',
            'deskripsi'  => 'nullable|string',
        ], [
            'tipe_kamar_id.required' => 'Tipe kamar wajib dipilih!',
            'tipe_kamar_id.exists'   => 'Tipe kamar tidak valid!',
            'nomor_kamar.required'  => 'Nomor kamar wajib diisi!',
            'nomor_kamar.unique'    => 'Nomor kamar sudah ada!',
            'status.required'       => 'Status wajib dipilih!',
        ]);

        $Kamar = Kamar::create($request->all());

            ActivityLogger::log(
            action: 'create',
            module: 'kamar',
            description: "Menambahkan kamar baru {$Kamar->nomor_kamar}"
        );

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kamar $kamar)
    {
        return redirect()->route('admin.kamar.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kamar $kamar)
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'tipeKamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
            'nomor_kamar'  => 'required|string|unique:kamar,nomor_kamar,' . $kamar->id,
            'status'       => 'required|in:tersedia,terisi,perawatan',
            'deskripsi'  => 'nullable|string',
        ], [
            'tipe_kamar_id.required' => 'Tipe kamar wajib dipilih!',
            'tipe_kamar_id.exists'   => 'Tipe kamar tidak valid!',
            'nomor_kamar.required'  => 'Nomor kamar wajib diisi!',
            'nomor_kamar.unique'    => 'Nomor kamar sudah ada!',
            'status.required'       => 'Status wajib dipilih!',
        ]);
        
        if ($request->status === 'tersedia') {
                $adaBookingAktif = $kamar->bookings()
                    ->whereIn('status', ['checked_in', 'confirmed'])
                    ->exists();

                if ($adaBookingAktif) {
                    return redirect()->back()
                        ->withErrors(['status' => 'Kamar ini masih memiliki booking aktif, tidak bisa diubah ke Tersedia!'])
                        ->withInput();
                }
            }

        $kamar->update($request->all());

        ActivityLogger::log(
            action: 'update',
            module: 'kamar',
            description: "Memperbarui kamar {$kamar->nomor_kamar}"
        );

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        $nomorKamar = $kamar->delete();
        ActivityLogger::log(
        action: 'delete',
        module: 'kamar',
        description: "Menghapus kamar {$nomorKamar}"
    );
        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus!');
    }
}
