@extends('layouts.app')

@section('page-title', 'Detail Booking')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Header & Tombol Kembali --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Detail Booking #{{ $booking->id }}</h5>
                <p class="text-sm text-gray-400 mb-0">Informasi lengkap transaksi & status reservasi</p>
            </div>
        </div>

        {{-- Notifikasi Flash Session --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-xl border border-emerald-100 bg-emerald-50 text-sm text-emerald-800 flex items-center gap-3 shadow-sm">
                <i class="bi bi-check-circle-fill text-emerald-500 text-base"></i>
                <div class="flex-1 font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 p-4 rounded-xl border border-red-100 bg-red-50 text-sm text-red-800 flex items-center gap-3 shadow-sm">
                <i class="bi bi-x-circle-fill text-red-500 text-base"></i>
                <div class="flex-1 font-medium">{{ session('error') }}</div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            {{-- Info Utama Booking --}}
            <div class="md:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-white">
                    <h6 class="font-bold text-gray-800 mb-0">Informasi Lengkap Reservasi</h6>
                    @php
                        // Konversi badge status Bootstrap ke utilitas warna Tailwind CSS
                        $statusConfig = [
                            'pending' => ['bg-amber-50 text-amber-700 border-amber-200', 'Pending'],
                            'confirmed' => ['bg-blue-50 text-blue-700 border-blue-200', 'Confirmed'],
                            'checked_in' => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'Checked In'],
                            'checked_out' => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'Checked Out'],
                            'cancelled' => ['bg-red-50 text-red-700 border-red-200', 'Cancelled'],
                        ];
                        $cfg = $statusConfig[$booking->status] ?? [
                            'bg-gray-50 text-gray-700 border-gray-200',
                            'Unknown',
                        ];
                    @endphp
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold border uppercase tracking-wider {{ $cfg[0] }}">
                        {{ $cfg[1] }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                        <div>
                            <small class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Nama
                                Tamu</small>
                            <span class="text-sm font-semibold text-gray-800">{{ $booking->tamu->nama_lengkap }}</span>
                        </div>
                        <div>
                            <small class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. KTP
                                / Paspor</small>
                            <span
                                class="text-sm font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 inline-block">{{ $booking->tamu->identity_number }}</span>
                        </div>

                        <div class="sm:col-span-2 my-1 border-t border-gray-50"></div>

                        <div>
                            <small class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Nomor
                                Kamar</small>
                            <span class="text-2xl font-black text-slate-800 tracking-tight block">
                                <i class="bi bi-door-closed text-indigo-500 mr-1"></i>{{ $booking->kamar->nomor_kamar }}
                            </span>
                        </div>
                        <div>
                            <small class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Tipe
                                Kamar</small>
                            <span
                                class="text-sm font-medium text-gray-700 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-lg inline-block mt-0.5">
                                {{ $booking->kamar->tipeKamar->nama_tipe_kamar }}
                            </span>
                        </div>

                        <div class="sm:col-span-2 my-1 border-t border-gray-50"></div>

                        <div>
                            <small
                                class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Check-In</small>
                            <span class="text-sm font-semibold text-gray-700 flex items-center gap-1.5 mt-0.5">
                                <i class="bi bi-calendar-check text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                            </span>
                        </div>
                        <div>
                            <small
                                class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Check-Out</small>
                            <span class="text-sm font-semibold text-gray-700 flex items-center gap-1.5 mt-0.5">
                                <i class="bi bi-calendar-x text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                            </span>
                        </div>

                        <div
                            class="sm:col-span-2 p-4 bg-slate-50 border border-slate-100/70 rounded-xl grid grid-cols-3 text-center divide-x divide-slate-200 mt-2">
                            <div>
                                <small
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total
                                    Malam</small>
                                <span class="text-sm font-bold text-gray-800">{{ $booking->total_nights }} malam</span>
                            </div>
                            <div>
                                <small
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Harga
                                    / Malam</small>
                                <span class="text-sm font-medium text-gray-600">Rp
                                    {{ number_format($booking->kamar->tipeKamar->harga_per_malam, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <small
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total
                                    Bayar</small>
                                <span class="text-base font-black text-emerald-600">Rp
                                    {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if ($booking->catatan)
                            <div class="sm:col-span-2 bg-amber-50/50 border border-amber-100/70 rounded-xl p-3.5">
                                <small
                                    class="block text-[11px] font-bold text-amber-800/80 uppercase tracking-wider mb-1">Catatan
                                    Tambahan / Permintaan Khusus</small>
                                <p class="text-sm text-amber-900 mb-0 leading-relaxed italic">"{{ $booking->catatan }}"</p>
                            </div>
                        @endif

                        <div
                            class="sm:col-span-2 text-xs text-gray-400 flex items-center gap-1.5 pt-2 border-t border-gray-50">
                            <i class="bi bi-person-badge"></i>
                            <span>Ditangani oleh operator: <strong
                                    class="font-semibold text-gray-600">{{ $booking->handledBy->name ?? '-' }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Panel Panel Aksi Kelola --}}
            <div class="md:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-gray-50 bg-white">
                    <h6 class="font-bold text-gray-800 mb-0 flex items-center gap-2">
                        <i class="bi bi-sliders text-indigo-500"></i>
                        Aksi Manajemen
                    </h6>
                </div>
                <div class="p-5 space-y-3">

                    {{-- Konfirmasi --}}
                    @if ($booking->status === 'pending')
                        <form action="{{ route(auth()->user()->role . '.bookings.confirm', $booking) }}" method="POST">
                            @csrf
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition active:scale-[0.99]">
                                <i class="bi bi-check-circle"></i> Konfirmasi Booking
                            </button>
                        </form>
                    @endif

                    {{-- Check-In --}}
                    {{-- @if ($booking->status === 'confirmed')
                        <form action="{{ route(auth()->user()->role . '.bookings.check-in', $booking) }}" method="POST">
                            @csrf
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition active:scale-[0.99]">
                                <i class="bi bi-box-arrow-in-right"></i> Proses Check-In
                            </button>
                        </form>
                    @endif --}}

                    {{-- Check-Out --}}
                    @if ($booking->status === 'checked_in')
                        <form action="{{ route(auth()->user()->role . '.bookings.check-out', $booking) }}" method="POST">
                            @csrf
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-slate-700 hover:bg-slate-800 text-white text-sm font-semibold shadow-sm transition active:scale-[0.99]">
                                <i class="bi bi-box-arrow-right"></i> Proses Check-Out
                            </button>
                        </form>
                    @endif

                    {{-- Edit --}}
                    @if (in_array($booking->status, ['pending', 'confirmed']))
                        <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow-sm transition no-underline">
                            <i class="bi bi-pencil"></i> Edit Detail Booking
                        </a>
                    @endif

                    {{-- Cancel / Pembatalan --}}
                    @if (!in_array($booking->status, ['checked_in', 'checked_out', 'cancelled']))
                        <form action="{{ route(auth()->user()->role . '.bookings.cancel', $booking) }}" method="POST"
                            onsubmit="return confirm('Yakin batalkan booking ini?')">
                            @csrf
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-sm font-semibold transition active:scale-[0.99]">
                                <i class="bi bi-x-circle"></i> Batalkan Booking
                            </button>
                        </form>
                    @endif

                    {{-- Bukti Penyelesaian Akhir --}}
                    @if ($booking->status === 'checked_out')
                        <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center text-emerald-800">
                            <i class="bi bi-check-circle-fill text-2xl text-emerald-500 block mb-1"></i>
                            <span class="text-sm font-bold block">Booking Selesai!</span>
                            <span class="text-[11px] text-emerald-600/90">Kamar telah dikosongkan & dibayar lunas</span>
                        </div>
                    @endif

                    @if ($booking->status === 'cancelled')
                        <div class="p-4 rounded-xl border border-red-200 bg-red-50/50 text-center text-red-800">
                            <i class="bi bi-x-circle-fill text-2xl text-red-500 block mb-1"></i>
                            <span class="text-sm font-bold block">Booking Dibatalkan</span>
                            <span class="text-[11px] text-red-600/90">Reservasi ini tidak berlaku lagi</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
