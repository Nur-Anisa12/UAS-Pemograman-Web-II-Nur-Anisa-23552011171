@extends('layouts.app')

@section('page-title', 'Check-In Tamu')

@section('content')

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h5 class="text-xl font-bold text-slate-800">Check-In Tamu</h5>
            <p class="text-sm text-slate-500">Daftar tamu yang siap check-in</p>
        </div>
        <span class="inline-flex w-fit items-center rounded-full bg-blue-600 px-3.5 py-1.5 text-sm font-medium text-white">
            Hari ini: {{ \Carbon\Carbon::today()->format('d M Y') }}
        </span>
    </div>

    @if (session('success'))
        <div
            class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <i class="bi bi-check-circle mt-0.5"></i>
            <span class="flex-1">{{ session('success') }}</span>
            <button type="button" onclick="this.closest('.mb-4')?.remove();" class="text-emerald-500 hover:text-emerald-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div
            class="mb-4 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <i class="bi bi-x-circle mt-0.5"></i>
            <span class="flex-1">{{ session('error') }}</span>
            <button type="button" onclick="this.closest('.mb-4')?.remove();" class="text-rose-500 hover:text-rose-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-3 mb-6 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-slate-800">{{ $stats['siap'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Siap Check-In</div>
        </div>
        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-emerald-600 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-emerald-600">{{ $stats['hari_ini'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Check-In Hari Ini</div>
        </div>
        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-rose-600 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-rose-600">{{ $stats['terlambat'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Terlambat Check-In</div>
        </div>
    </div>

    {{-- Search --}}
    <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
        <form method="GET" action="{{ route('petugas.checkin.index') }}">
            <div class="flex gap-2">
                <div
                    class="flex flex-1 items-center rounded-lg border border-slate-200 bg-slate-50 px-3 focus-within:border-teal-400 focus-within:ring-1 focus-within:ring-teal-400">
                    <i class="bi bi-search text-slate-400"></i>
                    <input type="text" name="search"
                        class="w-full border-0 bg-transparent px-3 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0"
                        placeholder="Cari nama tamu, no. identitas, atau nomor kamar..." value="{{ request('search') }}">
                </div>
                @if (request('search'))
                    <a href="{{ route('petugas.checkin.index') }}"
                        class="flex items-center justify-center rounded-lg border border-slate-200 px-3.5 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
                <button
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tamu</th>
                        <th class="px-4 py-3">No. Identitas</th>
                        <th class="px-4 py-3">Kamar</th>
                        <th class="px-4 py-3">Check-In</th>
                        <th class="px-4 py-3">Check-Out</th>
                        <th class="px-4 py-3 text-center">Malam</th>
                        <th class="px-4 py-3">Total Harga</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $item)
                        @php
                            $isToday = \Carbon\Carbon::parse($item->check_in_date)->isToday();
                            $isLate = \Carbon\Carbon::parse($item->check_in_date)->isPast() && !$isToday;
                        @endphp
                        <tr
                            class="transition {{ $isLate ? 'bg-rose-50/60 hover:bg-rose-50' : ($isToday ? 'bg-emerald-50/60 hover:bg-emerald-50' : 'hover:bg-slate-50/80') }}">
                            <td class="px-4 py-3.5 text-slate-500">
                                {{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-medium text-slate-800">{{ $item->tamu->nama_lengkap }}</div>
                                <div class="text-xs text-slate-400">{{ $item->tamu->no_telepon }}</div>
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-slate-500">{{ $item->tamu->identity_number }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-slate-800">{{ $item->kamar->nomor_kamar }}</div>
                                <div class="text-xs text-slate-400">{{ $item->kamar->tipeKamar->nama_tipe_kamar }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                <div class="flex items-center gap-1.5">
                                    {{ \Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}
                                    @if ($isToday)
                                        <span
                                            class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-medium text-emerald-700">Hari
                                            ini</span>
                                    @elseif($isLate)
                                        <span
                                            class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-[11px] font-medium text-rose-700">Terlambat</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-center text-slate-600">{{ $item->total_malam }} malam</td>
                            <td class="px-4 py-3.5 font-semibold text-emerald-600">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5">
                                {{-- Tombol Check-In --}}
                                {{-- Pakai id_booking eksplisit --}}
                                <form action="{{ route('petugas.checkin.process', $item->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Proses Check-In untuk {{ $item->tamu->nama_lengkap }}?')">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                        <i class="bi bi-box-arrow-in-right"></i> Check-In
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-20 text-center">
                                <i class="bi bi-inbox text-5xl text-slate-300"></i>
                                <p class="mt-3 text-sm text-slate-400">
                                    @if (request('search'))
                                        Tidak ada hasil untuk "{{ request('search') }}"
                                    @else
                                        Tidak ada tamu yang perlu check-in saat ini
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="border-t border-slate-100 bg-white px-4 py-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

@endsection
