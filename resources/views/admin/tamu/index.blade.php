@extends('layouts.app')
@section('page-title', 'Data Tamu')
@section('content')

    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h5 class="text-lg font-bold text-gray-800">Data Tamu</h5>
                <p class="text-sm text-gray-500 mt-0.5">Kelola data tamu hotel</p>
            </div>
            <a href="{{ route(auth()->user()->role . '.tamu.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium no-underline text-white shadow-sm shadow-blue-200 transition-colors hover:bg-blue-700">
                <i class="bi bi-plus-lg"></i> Tambah Tamu
            </a>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div id="success-alert"
                class="flex items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <span class="flex items-center gap-2">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </span>
                <button type="button" onclick="document.getElementById('success-alert').remove()"
                    class="text-emerald-500 hover:text-emerald-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        {{-- Search Bar --}}
        <form method="GET" action="{{ route(auth()->user()->role . '.tamu.index') }}">
            <div
                class="flex rounded-lg ring-1 ring-gray-200 bg-white overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-shadow">
                <span class="flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search"
                    class="w-full border-0 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                    placeholder="Cari nama, nomor KTP, atau nomor HP..." value="{{ request('search') }}">
                @if (request('search'))
                    <a href="{{ route(auth()->user()->role . '.tamu.index') }}"
                        class="flex items-center gap-1.5 px-3 text-sm text-gray-400 hover:text-gray-600 border-l border-gray-100">
                        <i class="bi bi-x-lg"></i> Reset
                    </a>
                @endif
                <button type="submit"
                    class="flex items-center gap-1.5 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
                    Cari
                </button>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-12">No</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Nama Lengkap</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">No. KTP/Paspor</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">No. HP</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Alamat</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-500">Total Booking</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tamu as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $loop->iteration + ($tamu->currentPage() - 1) * $tamu->perPage() }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar huruf pertama nama --}}
                                        <div
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">
                                            {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $item->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 font-mono text-xs text-gray-600">
                                    {{ $item->identity_number }}
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $item->no_telepon }}</td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ Str::limit($item->alamat, 40) ?? '-' }}
                                </td>
                                <td class="px-3 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-700">
                                        {{ $item->bookings_count }}x booking
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route(auth()->user()->role . '.tamu.show', $item) }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 transition-colors">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route(auth()->user()->role . '.tamu.edit', $item) }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route(auth()->user()->role . '.tamu.destroy', $item) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Yakin hapus data tamu {{ $item->nama_lengkap }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100 text-rose-600 hover:bg-rose-200 transition-colors">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-gray-400">
                                    @if (request('search'))
                                        <i class="bi bi-search text-3xl"></i>
                                        <p class="mt-2 text-sm">Tidak ada hasil untuk "<strong
                                                class="text-gray-600">{{ request('search') }}</strong>"</p>
                                    @else
                                        <i class="bi bi-inbox text-3xl"></i>
                                        <p class="mt-2 text-sm">Belum ada data tamu</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination + info --}}
            @if ($tamu->hasPages() || $tamu->total() > 0)
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 px-5 py-3">
                    <p class="text-xs text-gray-500">
                        Menampilkan {{ $tamu->firstItem() }}–{{ $tamu->lastItem() }}
                        dari {{ $tamu->total() }} tamu
                    </p>
                    <div class="text-sm">
                        {{ $tamu->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
