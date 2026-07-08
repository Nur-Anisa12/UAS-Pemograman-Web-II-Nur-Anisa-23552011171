@extends('layouts.app')

@section('page-title', 'Edit Booking')

@section('content')

    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Header & Tombol Kembali --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h5 class="font-bold text-xl text-gray-800 mb-0 leading-tight">Edit Booking #{{ $booking->id }}</h5>
                <p class="text-sm text-gray-400 mb-0">Ubah data reservasi</p>
            </div>
        </div>

        {{-- Card Form Utama --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{ route(auth()->user()->role . '.bookings.update', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        {{-- Input Tamu --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Tamu <span class="text-red-500">*</span>
                            </label>
                            @php
                                $tamuIdClass = $errors->has('tamu_id')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <select name="tamu_id"
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $tamuIdClass }} text-sm font-medium transition focus:outline-none focus:ring-4">
                                @foreach ($tamuu as $guest)
                                    <option value="{{ $guest->id }}"
                                        {{ old('tamu_id', $booking->tamu_id) == $guest->id ? 'selected' : '' }}>
                                        {{ $guest->nama_lengkap }} — {{ $guest->identity_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tamu_id')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Input Kamar --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Kamar <span class="text-red-500">*</span>
                            </label>
                            @php
                                $kamarIdClass = $errors->has('kamar_id')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <select name="kamar_id" id="kamar_id"
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $kamarIdClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                onchange="updateRoomInfo(this)">
                                @foreach ($kamar as $room)
                                    <option value="{{ $room->id }}"
                                        data-price="{{ $room->tipeKamar->harga_per_malam }}"
                                        data-type="{{ $room->tipeKamar->nama_tipe_kamar }}"
                                        data-capacity="{{ $room->tipeKamar->kapasitas }}"
                                        {{ old('kamar_id', $booking->kamar_id) == $room->id ? 'selected' : '' }}>
                                        Kamar {{ $room->nomor_kamar }} — {{ $room->tipeKamar->nama_tipe_kamar }} — Rp
                                        {{ number_format($room->tipeKamar->harga_per_malam, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
                            @error('kamar_id')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Baris Tanggal Check-In & Check-Out --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Check-In --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Check-In <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $checkInClass = $errors->has('check_in_date')
                                        ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                        : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                                @endphp
                                <input type="date" name="check_in_date" id="check_in_date"
                                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $checkInClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                    value="{{ old('check_in_date', $booking->check_in_date) }}" onchange="hitungTotal()">
                                @error('check_in_date')
                                    <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Check-Out --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Check-Out <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $checkOutClass = $errors->has('check_out_date')
                                        ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                        : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                                @endphp
                                <input type="date" name="check_out_date" id="check_out_date"
                                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $checkOutClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                    value="{{ old('check_out_date', $booking->check_out_date) }}" onchange="hitungTotal()">
                                @error('check_out_date')
                                    <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                            <select name="status"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-sm font-semibold transition focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500">
                                @foreach (['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', $booking->status) == $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan</label>
                            <textarea name="catatan" rows="2"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 text-sm font-medium transition focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500"
                                placeholder="Tambahkan catatan di sini...">{{ old('catatan', $booking->catatan) }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm hover:shadow transition active:scale-[0.98]">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 hover:text-gray-800 text-sm font-semibold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateRoomInfo(select) {
            hitungTotal();
        }

        function hitungTotal() {
            const roomSelect = document.getElementById('kamar_id');
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            const opt = roomSelect.options[roomSelect.selectedIndex];
            if (!roomSelect.value || !checkIn || !checkOut) return;
            const nights = Math.round((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24));
            if (nights > 0) console.log(nights + ' malam = Rp ' + (nights * Number(opt.dataset.price)).toLocaleString(
                'id-ID'));
        }
    </script>

@endsection
