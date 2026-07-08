@extends('layouts.app')
@section('page-title', 'Data Kamar')
@section('content')

    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h5 class="text-lg font-bold text-gray-800">Data Kamar</h5>
                <p class="text-sm text-gray-500 mt-0.5">Kelola kamar fisik yang tersedia di hotel</p>
            </div>
            <a href="{{ route('admin.kamar.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white no-underline shadow-sm shadow-blue-200 transition-colors hover:bg-blue-700 hover:no-underline">
                <i class="bi bi-plus-lg"></i>
                Tambah Kamar
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

        {{-- Search + Filter --}}
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <form action="{{ route('admin.kamar.index') }}" method="GET" class="flex gap-2">
                @if (!empty($status))
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="flex rounded-lg ring-1 ring-gray-200 bg-white overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-shadow"
                    style="min-width: 280px;">
                    <span class="flex items-center pl-3 text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search"
                        class="w-full border-0 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        placeholder="Cari no. kamar atau tipe..." value="{{ $search ?? '' }}">
                    @if (!empty($search))
                        <a href="{{ route('admin.kamar.index', array_filter(['status' => $status])) }}"
                            class="flex items-center px-3 text-gray-400 hover:text-gray-600 border-l border-gray-100">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Filter Status --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.kamar.index', array_filter(['search' => $search])) }}"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-medium transition-colors no-underline 
                    {{ empty($status) ? 'bg-gray-700 text-white shadow-sm' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50' }}">
                    Semua <span class="font-bold">{{ $summary['semua'] }}</span>
                </a>
                <a href="{{ route('admin.kamar.index', array_filter(['search' => $search, 'status' => 'tersedia'])) }}"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-medium transition-colors no-underline 
                    {{ $status === 'tersedia' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-200' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50' }}">
                    <span
                        class="h-1.5 w-1.5 rounded-full {{ $status === 'tersedia' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                    Tersedia <span class="font-bold">{{ $summary['tersedia'] }}</span>
                </a>
                <a href="{{ route('admin.kamar.index', array_filter(['search' => $search, 'status' => 'terisi'])) }}"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-medium transition-colors no-underline 
                    {{ $status === 'terisi' ? 'bg-rose-600 text-white shadow-sm shadow-rose-200' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50' }}">
                    <span class="h-1.5 w-1.5 rounded-full {{ $status === 'terisi' ? 'bg-white' : 'bg-rose-500' }}"></span>
                    Terisi <span class="font-bold">{{ $summary['terisi'] }}</span>
                </a>
                <a href="{{ route('admin.kamar.index', array_filter(['search' => $search, 'status' => 'perawatan'])) }}"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-medium transition-colors no-underline 
                    {{ $status === 'perawatan' ? 'bg-amber-500 text-white shadow-sm shadow-amber-200' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50' }}">
                    <span
                        class="h-1.5 w-1.5 rounded-full {{ $status === 'perawatan' ? 'bg-white' : 'bg-amber-500' }}"></span>
                    Maintenance <span class="font-bold">{{ $summary['perawatan'] }}</span>
                </a>
            </div>

        </div>

        {{-- Tabel --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-12">No</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">No. Kamar</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Tipe Kamar</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Harga/Malam</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Kapasitas</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Status</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kamar as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $loop->iteration + ($kamar->currentPage() - 1) * $kamar->perPage() }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="text-xl font-bold text-gray-800">{{ $item->nomor_kamar }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                        {{ $item->tipeKamar->nama_tipe_kamar }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold text-emerald-600">
                                        Rp {{ number_format($item->tipeKamar->harga_per_malam, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    <span class="flex items-center gap-1.5">
                                        <i class="bi bi-people text-gray-400"></i>
                                        {{ $item->tipeKamar->kapasitas }} orang
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $statusConfig = [
                                            'tersedia' => [
                                                'bg-emerald-100 text-emerald-700',
                                                'Tersedia',
                                                'bg-emerald-500',
                                            ],
                                            'terisi' => ['bg-rose-100 text-rose-700', 'Terisi', 'bg-rose-500'],
                                            'perawatan' => [
                                                'bg-amber-100 text-amber-700',
                                                'Maintenance',
                                                'bg-amber-500',
                                            ],
                                        ];
                                        $config = $statusConfig[$item->status] ?? [
                                            'bg-gray-100 text-gray-700',
                                            $item->status,
                                            'bg-gray-400',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ $config[0] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $config[2] }}"></span>
                                        {{ $config[1] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.kamar.edit', $item) }}"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.kamar.destroy', $item) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin hapus kamar {{ $item->nomor_kamar }}?')">
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
                                    <i class="bi bi-inbox text-3xl"></i>
                                    <p class="mt-2 text-sm">
                                        @if (!empty($search) || !empty($status))
                                            Tidak ada kamar yang cocok dengan filter ini
                                        @else
                                            Belum ada data kamar
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination + info --}}
            @if ($kamar->hasPages() || $kamar->total() > 0)
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 px-5 py-3">
                    <p class="text-xs text-gray-500">
                        Menampilkan {{ $kamar->firstItem() }}–{{ $kamar->lastItem() }}
                        dari {{ $kamar->total() }} kamar
                    </p>
                    <div class="text-sm">
                        {{ $kamar->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
