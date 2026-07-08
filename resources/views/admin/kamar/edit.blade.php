@extends('layouts.app')

@section('page-title', 'Edit Kamar')

@section('content')

    @php
        // Base classes untuk input Tailwind
        $inputBase =
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 bg-white';

        // State pembeda saat input divalidasi normal vs eror
        $stateNormal = 'border-gray-200 focus:ring-indigo-500/40 focus:border-indigo-500';
        $stateError = 'border-red-400 focus:ring-red-400/40 focus:border-red-500';
    @endphp

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.kamar.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Edit Kamar {{ $kamar->nomor_kamar }}</h5>
                <p class="text-sm text-gray-400 mb-0">Ubah detail informasi data kamar hotel saat ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Accent header strip (Indigo/Sky theme untuk mencerminkan tombol update) --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400"></div>

            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.kamar.update', $kamar) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nomor Kamar --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor Kamar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_kamar"
                            class="{{ $inputBase }} {{ $errors->has('nomor_kamar') ? $stateError : $stateNormal }}"
                            value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}">
                        @error('nomor_kamar')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tipe Kamar (dropdown) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Tipe Kamar <span class="text-red-500">*</span>
                        </label>
                        <select name="tipe_kamar_id"
                            class="{{ $inputBase }} {{ $errors->has('tipe_kamar_id') ? $stateError : $stateNormal }} py-[11px]">
                            <option value="">-- Pilih Tipe Kamar --</option>
                            @foreach ($tipeKamar as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('tipe_kamar_id', $kamar->tipe_kamar_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} — Rp
                                    {{ number_format($type->harga_per_malam, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                        @error('tipe_kamar_id')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                            class="{{ $inputBase }} {{ $errors->has('status') ? $stateError : $stateNormal }} py-[11px]">
                            <option value="tersedia" {{ old('status', $kamar->status) == 'tersedia' ? 'selected' : '' }}>
                                ✅ Tersedia
                            </option>
                            <option value="terisi" {{ old('status', $kamar->status) == 'terisi' ? 'selected' : '' }}>
                                🔴 Terisi
                            </option>
                            <option value="perawatan" {{ old('status', $kamar->status) == 'perawatan' ? 'selected' : '' }}>
                                🔧 Maintenance
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan</label>
                        <textarea name="deskripsi" rows="3"
                            class="{{ $inputBase }} {{ $errors->has('deskripsi') ? $stateError : $stateNormal }}">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
                        @error('deskripsi')
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
                        <a href="{{ route('admin.kamar.index') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 text-sm font-semibold hover:bg-gray-100 transition no-underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
