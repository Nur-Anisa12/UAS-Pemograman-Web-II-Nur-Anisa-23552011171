@extends('layouts.app')
@section('page-title', 'Kelola User')
@section('content')

    {{-- Header --}}
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h5 class="text-xl font-bold text-slate-800">Kelola User</h5>
            <p class="text-sm text-slate-500">Buat dan kelola akun Admin & Petugas</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold no-underline text-white shadow-sm shadow-teal-600/20 transition hover:bg-teal-700 active:bg-teal-800">
            <i class="bi bi-person-plus"></i> Buat Akun Baru
        </a>
    </div>

    {{-- Alert --}}
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

    {{-- Search + Filter Role --}}
    <div class="mb-4 flex flex-wrap items-center gap-3">

        {{-- Search --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
            @if (!empty($role))
                <input type="hidden" name="role" value="{{ $role }}">
            @endif
            <div
                class="flex w-full max-w-[340px] items-center rounded-lg border border-slate-200 bg-slate-50 px-3 focus-within:border-teal-400 focus-within:ring-1 focus-within:ring-teal-400">
                <i class="bi bi-search text-slate-400"></i>
                <input type="text" name="search"
                    class="w-full border-0 bg-transparent px-3 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0"
                    placeholder="Cari nama atau email..." value="{{ $search ?? '' }}">
            </div>
            @if (!empty($search))
                <a href="{{ route('admin.users.index', array_filter(['role' => $role])) }}"
                    class="flex items-center justify-center rounded-lg border border-slate-200 px-3.5 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        {{-- Filter Role --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.users.index', array_filter(['search' => $search])) }}"
                class="rounded-full px-3.5 py-1.5 text-xs font-semibold no-underline transition {{ empty($role) ? 'bg-slate-800 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.users.index', array_filter(['search' => $search, 'role' => 'admin'])) }}"
                class="rounded-full px-3.5 py-1.5 text-xs font-semibold no-underline transition {{ $role === 'admin' ? 'bg-teal-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                Admin
            </a>
            <a href="{{ route('admin.users.index', array_filter(['search' => $search, 'role' => 'petugas'])) }}"
                class="rounded-full px-3.5 py-1.5 text-xs font-semibold no-underline transition {{ $role === 'petugas' ? 'bg-emerald-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                Petugas
            </a>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Dibuat</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-4 py-3.5 text-slate-500">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-semibold text-white {{ $user->role === 'admin' ? 'bg-slate-800' : 'bg-emerald-600' }}">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ $user->name }}</div>
                                        @if ($user->id === auth()->id())
                                            <div class="text-xs text-slate-400">(Akun kamu)</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-500">{{ $user->email }}</td>
                            <td class="px-4 py-3.5">
                                @if ($user->role === 'admin')
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-200">
                                        Admin
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                        Petugas
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-xs text-slate-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.users.edit', $user) }}" title="Edit"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin hapus akun {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Hapus"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-600 transition hover:bg-rose-100">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button title="Tidak bisa hapus akun sendiri" disabled
                                            class="inline-flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-lg bg-slate-100 text-slate-300">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <i class="bi bi-people text-4xl text-slate-300"></i>
                                <p class="mt-3 text-sm text-slate-400">
                                    @if (!empty($search) || !empty($role))
                                        Tidak ada user yang cocok dengan filter ini
                                    @else
                                        Belum ada user
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination + info --}}
        @if ($users->hasPages() || $users->total() > 0)
            <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 bg-white px-4 py-3">
                <span class="text-xs text-slate-500">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                    dari {{ $users->total() }} user
                </span>
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection
