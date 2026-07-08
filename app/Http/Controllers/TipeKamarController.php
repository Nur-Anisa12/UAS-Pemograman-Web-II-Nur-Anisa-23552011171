<?php

namespace App\Http\Controllers;

use App\Models\TipeKamar;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class TipeKamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $TipeKamar = TipeKamar::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_tipe_kamar', 'like', "%{$search}%")
                    ->orWhere('deskripsi_kamar', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // penting: agar query search ikut di link pagination

        return view('admin.tipe-kamar.index', compact('TipeKamar', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tipe-kamar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dulu
        $request->validate([
            'nama_tipe_kamar' => 'required|string|max:255',
            'deskripsi_kamar'     => 'nullable|string',
            'harga_per_malam' => 'required|numeric|min:0',
            'kapasitas'        => 'required|integer|min:1',
        ], [
            // Pesan error dalam bahasa Indonesia
            'nama_tipe_kamar.required' => 'Nama tipe kamar wajib diisi!',
            'harga_per_malam.required' => 'Harga per malam wajib diisi!',
            'harga_per_malam.numeric'  => 'Harga harus berupa angka!',
            'kapasitas.required'        => 'Kapasitas wajib diisi!',
            'kapasitas.integer'         => 'Kapasitas harus berupa angka bulat!',
        ]);

        // Simpan ke database
        $tipeKamar = TipeKamar::create($request->all());

        ActivityLogger::log(
            action: 'create',
            module: 'tipe_kamar',
            description: "Menambahkan tipe kamar: {$tipeKamar->nama_tipe_kamar}"
        );

        // Redirect ke halaman list dengan pesan sukses
        return redirect()->route('admin.tipe-kamar.index')
            ->with('success', 'Tipe kamar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipeKamar $tipeKamar)
    {
        return redirect()->route('admin.tipe-kamar.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipeKamar $tipeKamar)
    {
        return view('admin.tipe-kamar.edit', compact('tipeKamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipeKamar $tipeKamar)
    {
        $request->validate([
            'nama_tipe_kamar' => 'required|string|max:255',
            'deskripsi_kamar'     => 'nullable|string',
            'harga_per_malam' => 'required|numeric|min:0',
            'kapasitas'
            => 'required|integer|min:1',
        ], [
            'nama_tipe_kamar.required' => 'Nama tipe kamar wajib diisi!',
            'harga_per_malam.required' => 'Harga per malam wajib diisi!',
            'harga_per_malam.numeric'  => 'Harga harus berupa angka!',
            'kapasitas.required'        => 'Kapasitas wajib diisi!',
        ]);

        $tipeKamar->update($request->all());
        ActivityLogger::log(
            action: 'update',
            module: 'tipe_kamar',
            description: "Mengubah tipe kamar: {$tipeKamar->nama_tipe_kamar}"
        );

        return redirect()->route('admin.tipe-kamar.index')
            ->with('success', 'Tipe kamar berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipeKamar $tipeKamar)
    {
        $tipeKamar->delete();

        $nama = $tipeKamar->nama_tipe_kamar;
        $tipeKamar->delete();
        ActivityLogger::log(
            action: 'delete',
            module: 'tipe_kamar',
            description: "Menghapus tipe kamar: {$nama}"
        );

        return redirect()->route('admin.tipe-kamar.index')
            ->with('success', 'Tipe kamar berhasil dihapus!');
    }
}
