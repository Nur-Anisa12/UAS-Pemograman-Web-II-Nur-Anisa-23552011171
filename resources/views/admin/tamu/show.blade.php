@extends('layouts.app')

@section('page-title', 'Detail Tamu')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Header Tombol Kembali --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route(auth()->user()->role . '.tamu.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="font-bold text-lg text-gray-800 mb-0 leading-tight">Detail Tamu</h5>
                <p class="text-sm text-gray-400 mb-0">Informasi profil lengkap & riwayat kunjungan menginap</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            {{-- Kartu Info Tamu --}}
            <div class="md:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-6">
                {{-- Decorative top bar --}}
                <div class="h-1.5 bg-gradient-to-r from-indigo-600 to-sky-500"></div>

                <div class="p-6 text-center">
                    {{-- Avatar Bulat Dinamis --}}
                    <div
                        class="w-16 h-16 bg-slate-900 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-inner tracking-wider uppercase">
                        {{ substr($tamu->nama_lengkap, 0, 1) }}
                    </div>

                    <h5 class="font-bold text-lg text-gray-800 mb-0.5">{{ $tamu->nama_lengkap }}</h5>
                    <p
                        class="text-xs font-semibold text-indigo-600 bg-indigo-50 inline-block px-2.5 py-1 rounded-full uppercase tracking-wider mb-6">
                        Tamu Hotel
                    </p>

                    <div class="text-start space-y-4 border-t border-gray-50 pt-5">
                        <div>
                            <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. KTP
                                / Paspor</span>
                            <span
                                class="text-sm font-mono text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100 inline-block w-full">
                                {{ $tamu->identity_number }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Nomor
                                HP</span>
                            <span class="text-sm text-gray-700 font-medium flex items-center gap-1.5">
                                <i class="bi bi-telephone text-gray-400"></i> {{ $tamu->no_telepon }}
                            </span>
                        </div>
                        <div>
                            <span
                                class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Alamat</span>
                            <span class="text-sm text-gray-700 block leading-relaxed">
                                {{ $tamu->alamat ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span
                                class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Terdaftar
                                Sejak</span>
                            <span class="text-sm text-gray-700 font-medium flex items-center gap-1.5">
                                <i class="bi bi-calendar3 text-gray-400"></i> {{ $tamu->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Booking --}}
            <div class="md:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-white">
                    <h6 class="font-bold text-gray-800 flex items-center gap-2 mb-0">
                        <i class="bi bi-clock-history text-indigo-500"></i>
                        Riwayat Booking
                    </h6>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-100">
                        {{ $bookings->count() }}x Kunjungan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/70 border-b border-gray-100">
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Kamar</th>
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Tipe</th>
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Check-In
                                </th>
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Check-Out
                                </th>
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
                                <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $booking->kamar->nomor_kamar }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $booking->kamar->tipeKamar->nama_tipe_kamar }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-emerald-600 whitespace-nowrap">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            // Mapping kelas warna badge status versi Tailwind CSS
                                            $colors = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'checked_in' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'checked_out' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                            $currentBadge =
                                                $colors[$booking->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border uppercase tracking-wider {{ $currentBadge }}">
                                            {{ str_replace('_', ' ', $booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="bi bi-folder2-open text-3xl text-gray-300"></i>
                                            <span>Belum ada riwayat booking untuk tamu ini</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
