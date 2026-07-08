@extends('layouts.app')

@section('page-title', 'Laporan Reservasi')

@section('content')

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h5 class="text-xl font-bold text-slate-800">Laporan Reservasi</h5>
            <p class="text-sm text-slate-500">Rekap data reservasi hotel</p>
        </div>
        {{-- Tombol Export --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.laporan.excel', request()->query()) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold no-underline text-white shadow-sm shadow-emerald-600/20 transition hover:bg-emerald-700">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.laporan.pdf', request()->query()) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-semibold no-underline text-white shadow-sm shadow-rose-600/20 transition hover:bg-rose-700">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-3 mb-6 md:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Total Booking</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <div class="text-lg font-bold text-emerald-600">
                Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">Total Pendapatan</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-amber-600">{{ $stats['menginap'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Sedang Menginap</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-rose-600">{{ $stats['cancelled'] }}</div>
            <div class="mt-1 text-xs text-slate-500">Dibatalkan</div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-4 py-3.5">
            <h6 class="flex items-center gap-2 text-sm font-bold text-slate-800">
                <i class="bi bi-funnel text-teal-600"></i> Filter Laporan
            </h6>
        </div>
        <div class="p-4">
            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-xs font-medium text-slate-500">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ request('dari') }}"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                    </div>
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-xs font-medium text-slate-500">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ request('sampai') }}"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-xs font-medium text-slate-500">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                            <option value="">Semua</option>
                            @foreach (['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-xs font-medium text-slate-500">Tipe Kamar</label>
                        <select name="tipe_kamar_id"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                            <option value="">Semua</option>
                            @foreach ($tipeKamars as $tipe)
                                <option value="{{ $tipe->id }}"
                                    {{ request('tipe_kamar_id') == $tipe->id ? 'selected' : '' }}>
                                    {{ $tipe->nama_tipe_kamar }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2 flex items-end gap-2">
                        <button
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg  bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        @if (request()->hasAny(['dari', 'sampai', 'status', 'tipe_kamar_id']))
                            <a href="{{ route('admin.laporan.index') }}"
                                class="flex items-center justify-center rounded-lg border border-slate-200 px-3.5 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                                <i class="bi bi-x text-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Tamu</th>
                        <th class="px-4 py-3">Kamar</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Check-In</th>
                        <th class="px-4 py-3">Check-Out</th>
                        <th class="px-4 py-3 text-center">Malam</th>
                        <th class="px-4 py-3">Total Harga</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $item)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3.5 text-slate-500">
                                {{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-medium text-slate-800">{{ $item->tamu->nama_lengkap }}</div>
                                <div class="font-mono text-xs text-slate-400">{{ $item->tamu->identity_number }}</div>
                            </td>
                            <td class="px-4 py-3.5 font-semibold text-slate-800">{{ $item->kamar->nomor_kamar }}</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs text-slate-600">
                                    {{ $item->kamar->tipeKamar->nama_tipe_kamar }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-center text-slate-600">{{ $item->total_malam }}</td>
                            <td class="px-4 py-3.5 font-semibold text-emerald-600">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5">
                                @php
                                    $colors = [
                                        'pending' => ['bg-amber-50 text-amber-700 ring-amber-200', 'bg-amber-500'],
                                        'confirmed' => ['bg-sky-50 text-sky-700 ring-sky-200', 'bg-sky-500'],
                                        'checked_in' => [
                                            'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                            'bg-indigo-500',
                                        ],
                                        'checked_out' => [
                                            'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                            'bg-emerald-500',
                                        ],
                                        'cancelled' => ['bg-rose-50 text-rose-700 ring-rose-200', 'bg-rose-500'],
                                    ];
                                    $cfg = $colors[$item->status] ?? [
                                        'bg-slate-100 text-slate-600 ring-slate-200',
                                        'bg-slate-400',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $cfg[0] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $cfg[1] }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-16 text-center">
                                <i class="bi bi-inbox text-4xl text-slate-300"></i>
                                <p class="mt-3 text-sm text-slate-400">Tidak ada data reservasi</p>
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
