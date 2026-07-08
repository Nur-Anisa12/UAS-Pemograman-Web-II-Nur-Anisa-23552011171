@extends('layouts.app')

@section('page-title', 'Edit Tamu')

@section('content')

    @php
        // Base classes untuk elemen input standar berbasis Tailwind
        $inputBase =
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 bg-white';

        // State pembeda saat input divalidasi normal vs eror
        $stateNormal = 'border-gray-200 focus:ring-indigo-500/40 focus:border-indigo-500';
        $stateError = 'border-red-400 focus:ring-red-400/40 focus:border-red-500';

        // Kontainer grup input khusus untuk elemen Nomor HP
        $groupNormal =
            'border-gray-200 focus-within:ring-2 focus-within:ring-indigo-500/40 focus-within:border-indigo-500';
        $groupError = 'border-red-400 focus-within:ring-2 focus-within:ring-red-400/40 focus-within:border-red-500';
    @endphp

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route(auth()->user()->role . '.tamu.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Edit Data Tamu</h5>
                <p class="text-sm text-gray-400 mb-0">{{ $tamu->nama_lengkap }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Accent header strip  --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400"></div>

            <div class="p-6 sm:p-8">
                <form action="{{ route(auth()->user()->role . '.tamu.update', $tamu) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap"
                            class="{{ $inputBase }} {{ $errors->has('nama_lengkap') ? $stateError : $stateNormal }}"
                            value="{{ old('nama_lengkap', $tamu->nama_lengkap) }}">
                        @error('nama_lengkap')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- No. KTP / Paspor --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            No. KTP / Paspor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="identity_number"
                            class="{{ $inputBase }} {{ $errors->has('identity_number') ? $stateError : $stateNormal }}"
                            value="{{ old('identity_number', $tamu->identity_number) }}">
                        @error('identity_number')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="flex rounded-lg shadow-sm overflow-hidden border transition bg-white {{ $errors->has('no_telepon') ? $groupError : $groupNormal }}">
                            <span
                                class="inline-flex items-center px-3.5 bg-gray-50 text-gray-400 border-r border-gray-200 select-none text-base">
                                <i class="bi bi-phone"></i>
                            </span>
                            <input type="text" name="no_telepon"
                                class="w-full px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none bg-white"
                                value="{{ old('no_telepon', $tamu->no_telepon) }}">
                        </div>
                        @error('no_telepon')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="{{ $inputBase }} {{ $errors->has('alamat') ? $stateError : $stateNormal }}"
                            placeholder="Alamat lengkap tamu (opsional)">{{ old('alamat', $tamu->alamat) }}</textarea>
                        @error('alamat')
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
                        <a href="{{ route(auth()->user()->role . '.tamu.index') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 text-sm font-semibold hover:bg-gray-100 transition no-underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
