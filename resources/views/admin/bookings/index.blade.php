@extends('layouts.app')

@section('page-title', 'Data Booking')

@section('content')

    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h5 class="text-xl font-bold text-slate-800">Data Booking</h5>
            <p class="text-sm text-slate-500">Kelola semua reservasi hotel</p>
        </div>
        <a href="{{ route(auth()->user()->role . '.bookings.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white no-underline shadow-sm shadow-teal-600/20 transition hover:bg-teal-700 active:bg-teal-800">
            <i class="bi bi-plus-lg"></i> Buat Booking
        </a>
    </div>

    @if (session('success'))
        <div
            class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <i class="bi bi-check-circle mt-0.5"></i>
            <span class="flex-1">{{ session('success') }}</span>
            <button type="button" onclick="this.closest('.mb-4')?.remove();"
                class="text-emerald-500 hover:text-emerald-700">
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

    {{-- Filter & Search --}}
    <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route(auth()->user()->role . '.bookings.index') }}">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-6">
                    <div
                        class="flex items-center rounded-lg border border-slate-200 bg-slate-50 px-3 focus-within:border-teal-400 focus-within:ring-1 focus-within:ring-teal-400">
                        <i class="bi bi-search text-slate-400"></i>
                        <input type="text" name="search"
                            class="w-full border-0 bg-transparent px-3 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0"
                            placeholder="Cari nama tamu atau nomor kamar..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <select name="status"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                        </option>
                        <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In
                        </option>
                        <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>
                <div class="md:col-span-3 flex gap-2">
                    <button
                        class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Filter
                    </button>
                    @if (request('search') || request('status'))
                        <a href="{{ route(auth()->user()->role . '.bookings.index') }}"
                            class="flex items-center justify-center rounded-lg border border-slate-200 px-3.5 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                            <i class="bi bi-x text-lg"></i>
                        </a>
                    @endif
                </div>
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
                        <th class="px-4 py-3">Kamar</th>
                        <th class="px-4 py-3">Check-In</th>
                        <th class="px-4 py-3">Check-Out</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
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
                                <div class="text-xs text-slate-400">{{ $item->tamu->no_telepon }}</div>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-slate-800">{{ $item->kamar->nomor_kamar }}</div>
                                <div class="text-xs text-slate-400">{{ $item->kamar->tipeKamar->nama_tipe_kamar }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-emerald-600">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-slate-400">{{ $item->total_malam }} malam</div>
                            </td>
                            <td class="px-4 py-3.5">
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'bg-amber-50 text-amber-700 ring-amber-200',
                                            'bg-amber-500',
                                            'Pending',
                                        ],
                                        'confirmed' => [
                                            'bg-sky-50 text-sky-700 ring-sky-200',
                                            'bg-sky-500',
                                            'Confirmed',
                                        ],
                                        'checked_in' => [
                                            'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                            'bg-indigo-500',
                                            'Checked In',
                                        ],
                                        'checked_out' => [
                                            'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                            'bg-emerald-500',
                                            'Checked Out',
                                        ],
                                        'cancelled' => [
                                            'bg-rose-50 text-rose-700 ring-rose-200',
                                            'bg-rose-500',
                                            'Cancelled',
                                        ],
                                    ];
                                    $cfg = $statusConfig[$item->status];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $cfg[0] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $cfg[1] }}"></span>
                                    {{ $cfg[2] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    {{-- Detail --}}
                                    <a href="{{ route(auth()->user()->role . '.bookings.show', $item) }}" title="Detail"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600 transition hover:bg-sky-100">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Konfirmasi (pending → confirmed) --}}
                                    @if ($item->status === 'pending')
                                        <form action="{{ route(auth()->user()->role . '.bookings.confirm', $item) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button title="Konfirmasi"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 transition hover:bg-emerald-100">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Check-In (confirmed → checked_in) --}}
                                    {{-- @if ($item->status === 'confirmed')
                                        <form action="{{ route(auth()->user()->role . '.bookings.check-in', $item) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button title="Check-In"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-teal-50 text-teal-600 transition hover:bg-teal-100">
                                                <i class="bi bi-box-arrow-in-right"></i>
                                            </button>
                                        </form>
                                    @endif --}}

                                    {{-- Check-Out (checked_in → checked_out) --}}
                                    {{-- @if ($item->status === 'checked_in')
                                        <form action="{{ route(auth()->user()->role . '.bookings.check-out', $item) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button title="Check-Out"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-slate-200">
                                                <i class="bi bi-box-arrow-right"></i>
                                            </button>
                                        </form>
                                    @endif --}}


                                    {{-- Cancel --}}
                                    @if (!in_array($item->status, ['checked_in', 'checked_out', 'cancelled']))
                                        <form action="{{ route(auth()->user()->role . '.bookings.cancel', $item) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Yakin batalkan booking ini?')">
                                            @csrf
                                            <button title="Batalkan"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-600 transition hover:bg-rose-100">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center">
                                <i class="bi bi-inbox text-4xl text-slate-300"></i>
                                <p class="mt-3 text-sm text-slate-400">Belum ada data booking</p>
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
