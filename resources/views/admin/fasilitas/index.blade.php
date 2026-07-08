@extends('layouts.app')
@section('page-title', 'Fasilitas')
@section('content')

    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h5 class="text-lg font-bold text-gray-800">Daftar Fasilitas</h5>
                <p class="text-sm text-gray-500 mt-0.5">Kelola fasilitas yang tersedia di hotel</p>
            </div>
            <a href="{{ route('admin.fasilitas.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white no-underline shadow-sm shadow-blue-200 transition-colors hover:bg-blue-700 hover:no-underline">
                <i class="bi bi-plus-lg"></i>
                Tambah Fasilitas
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

        {{-- Search --}}
        <form action="{{ route('admin.fasilitas.index') }}" method="GET" class="max-w-sm">
            <div
                class="flex rounded-lg ring-1 ring-gray-200 bg-white overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-shadow">
                <span class="flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search"
                    class="w-full border-0 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                    placeholder="Cari nama atau deskripsi..." value="{{ $search ?? '' }}">
                @if (!empty($search))
                    <a href="{{ route('admin.fasilitas.index') }}"
                        class="flex items-center px-3 text-gray-400 hover:text-gray-600 border-l border-gray-100">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>

        {{-- Tabel --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-12">No</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Nama Fasilitas</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Deskripsi</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Tipe Kamar</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($fasilitas as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $loop->iteration + ($fasilitas->currentPage() - 1) * $fasilitas->perPage() }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-50 text-amber-500">
                                            <i class="bi bi-stars text-sm"></i>
                                        </span>
                                        <span class="font-medium text-gray-800">{{ $item->nama_fasilitas }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ Str::limit($item->deskripsi_fasilitas, 60) ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center justify-center rounded-full bg-sky-100 px-3 py-1.5 text-[11px] font-medium leading-none text-sky-700">
                                        {{ $item->tipekamar_count }} tipe kamar
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.fasilitas.edit', $item) }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.fasilitas.destroy', $item) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin hapus fasilitas {{ $item->nama_fasilitas }}?')">
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
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                                    <i class="bi bi-inbox text-3xl"></i>
                                    <p class="mt-2 text-sm">
                                        @if (!empty($search))
                                            Tidak ada hasil untuk "<strong
                                                class="text-gray-600">{{ $search }}</strong>"
                                        @else
                                            Belum ada fasilitas
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination + info --}}
            @if ($fasilitas->hasPages() || $fasilitas->total() > 0)
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 px-5 py-3">
                    <p class="text-xs text-gray-500">
                        Menampilkan {{ $fasilitas->firstItem() }}–{{ $fasilitas->lastItem() }}
                        dari {{ $fasilitas->total() }} data
                    </p>
                    <div class="text-sm">
                        {{ $fasilitas->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
