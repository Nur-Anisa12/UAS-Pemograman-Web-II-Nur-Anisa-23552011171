@extends('layouts.app')

@section('page-title', 'Edit Akun')

@section('content')

    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- Header & Tombol Kembali --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 shadow-sm transition">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h5 class="font-bold text-xl text-gray-800 mb-0 leading-tight">Edit Akun</h5>
                <p class="text-sm text-gray-400 mb-0">{{ $user->name }}</p>
            </div>
        </div>

        {{-- Card Form Utama --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            @php
                                $nameClass = $errors->has('name')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <input type="text" name="name"
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $nameClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            @php
                                $emailClass = $errors->has('email')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <input type="email" name="email"
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $emailClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            @php
                                $roleClass = $errors->has('role')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <select name="role"
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $roleClass }} text-sm font-medium transition focus:outline-none focus:ring-4">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    👑 Admin
                                </option>
                                <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>
                                    👤 Petugas
                                </option>
                            </select>
                            @error('role')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password opsional saat edit --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Password Baru
                            </label>
                            @php
                                $passwordClass = $errors->has('password')
                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                            @endphp
                            <div class="flex items-stretch gap-2">
                                <input type="password" name="password" id="password"
                                    class="flex-1 min-w-0 px-3.5 py-2.5 rounded-xl border {{ $passwordClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                    placeholder="Kosongkan jika tidak ingin ganti password">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="inline-flex items-center justify-center w-11 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1.5 text-xs text-gray-400">
                                Biarkan kosong jika tidak ingin mengubah password
                            </p>
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <div class="flex items-stretch gap-2">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="flex-1 min-w-0 px-3.5 py-2.5 rounded-xl border border-gray-200 text-gray-800 bg-white text-sm font-medium transition focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="inline-flex items-center justify-center w-11 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm hover:shadow transition active:scale-[0.98]">
                            <i class="bi bi-save"></i> Update Akun
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 hover:text-gray-800 text-sm no-underline font-semibold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>

@endsection
