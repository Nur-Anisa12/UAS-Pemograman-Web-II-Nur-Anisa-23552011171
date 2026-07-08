@extends('layouts.app')

@section('page-title', 'Edit Tipe Kamar')

@section('content')

    @php
        // Base classes untuk input Tailwind
        $inputBase =
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2';

        // State pembeda saat input divalidasi normal vs eror
        $stateNormal = 'border-gray-200 focus:ring-indigo-500/40 focus:border-indigo-500';
        $stateError = 'border-red-400 focus:ring-red-400/40 focus:border-red-500';

        // Kontainer grup input (Harga & Kapasitas)
        $groupNormal =
            'border-gray-200 focus-within:ring-2 focus-within:ring-indigo-500/40 focus-within:border-indigo-500';
        $groupError = 'border-red-400 focus-within:ring-2 focus-within:ring-red-400/40 focus-within:border-red-500';
    @endphp

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.tipe-kamar.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Edit Tipe Kamar</h5>
                <p class="text-sm text-gray-400 mb-0">Ubah detail informasi data tipe kamar saat ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Accent header strip --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400"></div>

            <div class="p-6 sm:p-8">
                {{-- ACTION pakai PUT karena ini update --}}
                <form action="{{ route('admin.tipe-kamar.update', $tipeKamar) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT') {{-- ← WAJIB ada ini untuk update! --}}

                    {{-- Nama Tipe Kamar --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Tipe Kamar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_tipe_kamar"
                            class="{{ $inputBase }} {{ $errors->has('nama_tipe_kamar') ? $stateError : $stateNormal }}"
                            value="{{ old('nama_tipe_kamar', $tipeKamar->nama_tipe_kamar) }}">
                        @error('nama_tipe_kamar')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Harga per Malam --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Harga per Malam <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="flex rounded-lg shadow-sm overflow-hidden border transition {{ $errors->has('harga_per_malam') ? $groupError : $groupNormal }}">
                            <span
                                class="inline-flex items-center px-3.5 bg-gray-50 text-gray-500 text-sm border-r border-gray-200 select-none">
                                Rp
                            </span>
                            <input type="number" name="harga_per_malam"
                                class="w-full px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none"
                                value="{{ old('harga_per_malam', $tipeKamar->harga_per_malam) }}" min="0">
                        </div>
                        @error('harga_per_malam')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Kapasitas --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Kapasitas <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="flex rounded-lg shadow-sm overflow-hidden border transition {{ $errors->has('kapasitas') ? $groupError : $groupNormal }}">
                            <input type="number" name="kapasitas"
                                class="w-full px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none"
                                value="{{ old('kapasitas', $tipeKamar->kapasitas) }}" min="1">
                            <span
                                class="inline-flex items-center px-3.5 bg-gray-50 text-gray-500 text-sm border-l border-gray-200 select-none">
                                orang
                            </span>
                        </div>
                        @error('kapasitas')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi_kamar" rows="3"
                            class="{{ $inputBase }} {{ $errors->has('deskripsi_kamar') ? $stateError : $stateNormal }}">{{ old('deskripsi_kamar', $tipeKamar->deskripsi_kamar) }}</textarea>
                        @error('deskripsi_kamar')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-semibold shadow-sm hover:bg-amber-600 active:scale-[0.98] transition">
                            <i class="bi bi-save"></i> Update Data
                        </button>
                        <a href="{{ route('admin.tipe-kamar.index') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 text-sm font-semibold hover:bg-gray-100 transition no-underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
