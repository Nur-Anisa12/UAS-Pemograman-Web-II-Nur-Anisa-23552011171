<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $fasilitas = Fasilitas::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_fasilitas', 'like', "%{$search}%")
                    ->orWhere('deskripsi_fasilitas', 'like', "%{$search}%");
            })
            ->withCount('Tipekamar')   // efisien, ganti ->count() di view
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.fasilitas.index', compact('fasilitas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas'        => 'required|string|max:255|unique:fasilitas,nama_fasilitas',
            'deskripsi_fasilitas' => 'nullable|string',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi!',
            'nama_fasilitas.unique'   => 'Fasilitas ini sudah ada!',
        ]);

        $fasilitas = Fasilitas::create($request->all());

        ActivityLogger::log(
            action: 'create',
            module: 'fasilitas',
            description: "Menambahkan fasilitas {$fasilitas->nama_fasilitas}"
        );

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fasilitas $fasilitas)
    {
        return redirect()->route('admin.fasilitas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama_fasilitas'        => 'required|string|max:255|unique:fasilitas,nama_fasilitas,' . $fasilitas->id,
            'deskripsi_fasilitas' => 'nullable|string',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi!',
            'nama_fasilitas.unique'   => 'Fasilitas ini sudah ada!',
        ]);

        $fasilitas->update($request->all());
        ActivityLogger::log(
            action: 'update',
            module: 'fasilitas',
            description: "Memperbarui fasilitas {$fasilitas->nama_fasilitas}"
        );

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fasilitas $fasilitas)
    {
        $namaFasilitas = $fasilitas->nama_fasilitas;
        $idFasilitas = $fasilitas->id;
        $fasilitas->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'fasilitas',
            description: "Menghapus fasilitas {$namaFasilitas}"
        );

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}
