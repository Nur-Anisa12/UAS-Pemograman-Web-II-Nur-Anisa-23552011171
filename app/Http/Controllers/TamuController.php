<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tamu = Tamu::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('identity_number', 'like', "%{$search}%")
                        ->orWhere('no_telepon', 'like', "%{$search}%");
                });
            })
            ->withCount('bookings')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tamu.index', compact('tamu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tamu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'identity_number' => 'required|string|unique:tamu,identity_number',
            'no_telepon'      => 'required|string|max:20',
            'alamat'          => 'nullable|string',
        ], [
            'nama_lengkap.required'    => 'Nama lengkap wajib diisi!',
            'identity_number.required' => 'Nomor KTP/Paspor wajib diisi!',
            'identity_number.unique'   => 'Nomor KTP/Paspor sudah terdaftar!',
            'no_telepon.required'      => 'Nomor HP wajib diisi!',
        ]);

        $tamu = Tamu::create($request->all());

        ActivityLogger::log(
            action: 'create',
            module: 'tamu',
            description: "Menambahkan tamu baru: {$tamu->nama_lengkap}"
        );

        return redirect()->route(Auth::user()->role . '.tamu.index')
            ->with('success', 'Data tamu berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tamu $tamu)
    {
        // Tampilkan detail tamu + riwayat booking
        $bookings = $tamu->bookings()->with('kamar.tipeKamar')->latest()->get();
        return view('admin.tamu.show', compact('tamu', 'bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tamu $tamu)
    {
        return view('admin.tamu.edit', compact('tamu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tamu $tamu)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'identity_number' => 'required|string|unique:tamu,identity_number,' . $tamu->id,
            'no_telepon'      => 'required|string|max:20',
            'alamat'          => 'nullable|string',
        ], [
            'nama_lengkap.required'    => 'Nama lengkap wajib diisi!',
            'identity_number.required' => 'Nomor KTP/Paspor wajib diisi!',
            'identity_number.unique'   => 'Nomor KTP/Paspor sudah terdaftar!',
            'no_telepon.required'      => 'Nomor HP wajib diisi!',
        ]);

        $tamu->update($request->all());
        ActivityLogger::log(
            action: 'update',
            module: 'tamu',
            description: "Mengubah data tamu: {$tamu->nama_lengkap}"
        );

        return redirect()->route(Auth::user()->role . '.tamu.index')
            ->with('success', 'Data tamu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tamu $tamu)
    {
        $nama = $tamu->nama_lengkap;
        $tamu->delete();
        ActivityLogger::log(
            action: 'delete',
            module: 'tamu',
            description: "Menghapus tamu: {$nama}"
        );

        $tamu->delete();

        return redirect()->route(Auth::user()->role . '.tamu.index')
            ->with('success', 'Data tamu berhasil dihapus!');
    }
}
