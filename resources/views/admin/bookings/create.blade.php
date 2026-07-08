@extends('layouts.app')

@section('page-title', 'Buat Booking')

@section('content')

    @php
        // Base classes untuk elemen input & select standar
        $inputBase =
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 shadow-sm transition focus:outline-none focus:ring-2 bg-white';

        // State pembeda saat input divalidasi normal vs eror
        $stateNormal = 'border-gray-200 focus:ring-indigo-500/40 focus:border-indigo-500';
        $stateError = 'border-red-400 focus:ring-red-400/40 focus:border-red-500';
    @endphp

    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Buat Booking Baru</h5>
                <p class="text-sm text-gray-400 mb-0">Isi form reservasi dan kelayakan kamar hotel</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Accent header strip --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400"></div>

            <div class="p-6 sm:p-8">
                <form action="{{ route(auth()->user()->role . '.bookings.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Pilih Tamu --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tamu <span class="text-red-500">*</span>
                            </label>
                            <select name="tamu_id"
                                class="{{ $inputBase }} {{ $errors->has('tamu_id') ? $stateError : $stateNormal }}">
                                <option value="">-- Pilih Tamu --</option>
                                @foreach ($tamu as $guest)
                                    <option value="{{ $guest->id }}"
                                        {{ old('tamu_id') == $guest->id ? 'selected' : '' }}>
                                        {{ $guest->nama_lengkap }} — {{ $guest->identity_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tamu_id')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @else
                                <p class="mt-1.5 text-xs text-gray-400">
                                    Tamu belum terdaftar?
                                    <a href="{{ route(auth()->user()->role . '.tamu.create') }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-700 font-medium underline">
                                        Tambah tamu baru
                                    </a>
                                </p>
                            @enderror
                        </div>

                        {{-- Pilih Kamar --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kamar <span class="text-red-500">*</span>
                            </label>
                            <select name="kamar_id" id="kamar_id"
                                class="{{ $inputBase }} {{ $errors->has('kamar_id') ? $stateError : $stateNormal }}"
                                onchange="updateRoomInfo(this)">
                                <option value="">-- Pilih Kamar (hanya yang tersedia) --</option>
                                @foreach ($kamar as $room)
                                    <option value="{{ $room->id }}"
                                        data-price="{{ $room->tipeKamar->harga_per_malam }}"
                                        data-type="{{ $room->tipeKamar->nama_tipe_kamar }}"
                                        data-capacity="{{ $room->tipeKamar->kapasitas }}"
                                        {{ old('kamar_id') == $room->id ? 'selected' : '' }}>
                                        Kamar {{ $room->nomor_kamar }} — {{ $room->tipeKamar->nama_tipe_kamar }} — Rp
                                        {{ number_format($room->tipeKamar->harga_per_malam, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
                            @error('kamar_id')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror

                            {{-- Panel Info Kamar (Dinamis JavaScript) --}}
                            <div id="room-info" class="mt-3 p-4 bg-slate-50 border border-slate-100 rounded-xl hidden">
                                <div class="grid grid-cols-3 text-center divide-x divide-slate-200/80">
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">Tipe</small>
                                        <span id="info-type" class="text-sm font-semibold text-gray-700"></span>
                                    </div>
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">Kapasitas</small>
                                        <span id="info-capacity" class="text-sm font-semibold text-gray-700"></span>
                                    </div>
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">Harga
                                            / Malam</small>
                                        <span id="info-price" class="text-sm font-bold text-indigo-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Check-In --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tanggal Check-In <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="check_in_date" id="check_in_date"
                                class="{{ $inputBase }} {{ $errors->has('check_in_date') ? $stateError : $stateNormal }}"
                                value="{{ old('check_in_date') }}" min="{{ date('Y-m-d') }}" onchange="hitungTotal()">
                            @error('check_in_date')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Tanggal Check-Out --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tanggal Check-Out <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="check_out_date" id="check_out_date"
                                class="{{ $inputBase }} {{ $errors->has('check_out_date') ? $stateError : $stateNormal }}"
                                value="{{ old('check_out_date') }}" onchange="hitungTotal()">
                            @error('check_out_date')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Preview Total Kustom (Dinamis JavaScript) --}}
                        <div class="md:col-span-2">
                            <div id="total-preview"
                                class="p-4 rounded-xl border border-emerald-100 bg-emerald-50/60 hidden">
                                <div class="grid grid-cols-3 text-center divide-x divide-emerald-200/60">
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-emerald-700/70 mb-0.5">Total
                                            Malam</small>
                                        <span id="preview-nights" class="text-base font-bold text-slate-800"></span>
                                    </div>
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-emerald-700/70 mb-0.5">Harga
                                            / Malam</small>
                                        <span id="preview-price" class="text-sm font-semibold text-slate-600"></span>
                                    </div>
                                    <div>
                                        <small
                                            class="block text-[11px] font-bold uppercase tracking-wider text-emerald-700/70 mb-0.5">Total
                                            Bayar</small>
                                        <span id="preview-total" class="text-lg font-black text-emerald-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan</label>
                            <textarea name="catatan" rows="2" class="{{ $inputBase }} {{ $stateNormal }}"
                                placeholder="Permintaan khusus tamu (opsional)">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-semibold shadow-sm hover:bg-indigo-700 active:scale-[0.98] transition">
                            <i class="bi bi-save"></i> Buat Booking
                        </button>
                        <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-50 text-gray-600 border border-gray-200 text-sm font-semibold hover:bg-gray-100 transition no-underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update info kamar saat dipilih
        function updateRoomInfo(select) {
            const opt = select.options[select.selectedIndex];
            if (opt.value) {
                document.getElementById('info-type').textContent = opt.dataset.type;
                document.getElementById('info-capacity').textContent = opt.dataset.capacity + ' orang';
                document.getElementById('info-price').textContent = 'Rp ' + Number(opt.dataset.price).toLocaleString(
                    'id-ID');
                document.getElementById('room-info').classList.remove('hidden');
            } else {
                document.getElementById('room-info').classList.add('hidden');
            }
            hitungTotal();
        }

        // Hitung total otomatis
        function hitungTotal() {
            const roomSelect = document.getElementById('kamar_id');
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            const opt = roomSelect.options[roomSelect.selectedIndex];

            if (!roomSelect.value || !checkIn || !checkOut) return;

            const msPerDay = 1000 * 60 * 60 * 24;
            const nights = Math.round((new Date(checkOut) - new Date(checkIn)) / msPerDay);
            const price = Number(opt.dataset.price);
            const total = nights * price;

            if (nights > 0) {
                document.getElementById('preview-nights').textContent = nights + ' malam';
                document.getElementById('preview-price').textContent = 'Rp ' + price.toLocaleString('id-ID');
                document.getElementById('preview-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('total-preview').classList.remove('hidden');
            } else {
                document.getElementById('total-preview').classList.add('hidden');
            }
        }
    </script>

@endsection
