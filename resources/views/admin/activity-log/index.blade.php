@extends('layouts.app')

@section('page-title', 'Log Activity')

@section('content')

    <div class="mb-6">
        <h5 class="text-xl font-bold text-slate-800">Log Activity</h5>
        <p class="text-sm text-slate-500">Riwayat aktivitas pengguna di sistem</p>
    </div>

    {{-- Filter --}}
    <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.activity-log.index') }}">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                </div>
                <div class="md:col-span-2">
                    <select name="module"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                        <option value="">Semua Modul</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module }}" {{ request('module') === $module ? 'selected' : '' }}>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <select name="action"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                        <option value="">Semua Aksi</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-teal-400 focus:outline-none focus:ring-1 focus:ring-teal-400">
                </div>
                <div class="md:col-span-3 flex gap-2">
                    <button
                        class="w-full rounded-lg bg-blue-600  px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('admin.activity-log.index') }}"
                        class="flex items-center justify-center rounded-lg border border-slate-200 px-3.5 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                        <i class="bi bi-x text-lg"></i>
                    </a>
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
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Modul</th>
                        <th class="px-4 py-3">Aksi</th>
                        <th class="px-4 py-3">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        @php
                            $actionConfig = [
                                'create' => [
                                    'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                    'bg-emerald-500',
                                    'Tambah',
                                ],
                                'update' => ['bg-amber-50 text-amber-700 ring-amber-200', 'bg-amber-500', 'Edit'],
                                'delete' => ['bg-rose-50 text-rose-700 ring-rose-200', 'bg-rose-500', 'Hapus'],
                                'checkin' => ['bg-teal-50 text-teal-700 ring-teal-200', 'bg-teal-500', 'Check-In'],
                                'checkout' => [
                                    'bg-slate-100 text-slate-600 ring-slate-200',
                                    'bg-slate-400',
                                    'Check-Out',
                                ],
                                'login' => ['bg-sky-50 text-sky-700 ring-sky-200', 'bg-sky-500', 'Login'],
                                'logout' => ['bg-slate-800/5 text-slate-700 ring-slate-300', 'bg-slate-700', 'Logout'],
                            ];
                            $cfg = $actionConfig[$log->action] ?? [
                                'bg-slate-100 text-slate-600 ring-slate-200',
                                'bg-slate-400',
                                $log->action,
                            ];
                        @endphp
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-4 py-3.5 text-xs text-slate-500">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-slate-800">{{ $log->user->name ?? 'Sistem' }}</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs text-slate-600">
                                    {{ ucfirst($log->module) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $cfg[0] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $cfg[1] }}"></span>
                                    {{ $cfg[2] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-20 text-center">
                                <i class="bi bi-clock-history text-5xl text-slate-300"></i>
                                <p class="mt-3 text-sm text-slate-400">Belum ada log activity</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="border-t border-slate-100 bg-white px-4 py-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

@endsection
