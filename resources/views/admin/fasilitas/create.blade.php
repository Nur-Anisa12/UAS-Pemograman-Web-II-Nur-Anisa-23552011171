@extends('layouts.app')

@section('page-title', 'Tambah Fasilitas')

@section('content')

    @php
        // Base classes dipakai di semua state input dan textarea
        $inputBase =
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2';

        // Hanya salah satu dari dua ini yang pernah dipakai per field (ternary)
        $stateNormal = 'border-gray-200 focus:ring-indigo-500/40 focus:border-indigo-500';
        $stateError = 'border-red-400 focus:ring-red-400/40 focus:border-red-500';
    @endphp

    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.fasilitas.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Tambah Fasilitas</h5>
                <p class="text-sm text-gray-400 mb-0">Tambahkan fasilitas baru untuk tipe kamar hotel</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Accent header strip --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400"></div>

            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.fasilitas.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Fasilitas --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Fasilitas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_fasilitas"
                            class="{{ $inputBase }} {{ $errors->has('nama_fasilitas') ? $stateError : $stateNormal }}"
                            value="{{ old('nama_fasilitas') }}" placeholder="contoh: AC, WiFi, Bathtub">
                        @error('nama_fasilitas')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi_fasilitas" rows="3"
                            class="{{ $inputBase }} {{ $errors->has('deskripsi_fasilitas') ? $stateError : $stateNormal }}"
                            placeholder="Deskripsi singkat mengenai detail fasilitas (opsional)">{{ old('deskripsi_fasilitas') }}</textarea>
                        @error('deskripsi_fasilitas')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-semibold shadow-sm hover:bg-indigo-700 active:scale-[0.98] transition">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.fasilitas.index') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 text-sm font-semibold hover:bg-gray-100 transition no-underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
