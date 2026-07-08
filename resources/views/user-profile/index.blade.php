@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Alert --}}
        @if (session('success'))
            <div id="success-alert"
                class="flex items-start gap-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 mb-6">
                <i class="bi bi-check-circle mt-0.5"></i>
                <p class="flex-1 leading-relaxed">{{ session('success') }}</p>
                <button type="button" onclick="document.getElementById('success-alert').remove()"
                    class="text-emerald-500 hover:text-emerald-700 transition">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Kartu Info Profil --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-6 text-center">

                        {{-- Avatar --}}
                        <div class="inline-block mb-3">
                            @if ($profile && $profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar"
                                    class="w-[90px] h-[90px] rounded-full object-cover border-4 border-[#1e3a5f]/10 ring-2 ring-[#1e3a5f]">
                            @else
                                <div
                                    class="w-[90px] h-[90px] rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-4xl font-bold mx-auto">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <h5 class="font-bold text-lg text-gray-800 mb-1">{{ $user->name }}</h5>
                        <p class="text-sm text-gray-400 mb-3">{{ $user->email }}</p>

                        {{-- Badge role --}}
                        @if ($user->role === 'admin')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">👑
                                Admin</span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">👤
                                Petugas</span>
                        @endif

                        <hr class="my-4 border-gray-100">

                        {{-- Info profil --}}
                        <div class="text-left space-y-2.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">No. Telepon</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $profile->no_telepon ?? '-' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Jenis Kelamin</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $profile->jenis_kelamin ?? '-' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Bergabung</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Edit Profil --}}
            <div class="md:col-span-2">

                {{-- Tab --}}
                <div class="flex" id="profileTab">
                    <button type="button" data-bs-toggle="tab" data-bs-target="#tab-profil"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-t-xl bg-white border border-b-0 border-gray-100 text-gray-800 text-sm font-semibold shadow-sm">
                        <i class="bi bi-person"></i> Edit Profil
                    </button>
                </div>

                <div class="tab-content">

                    {{-- Tab Edit Profil --}}
                    <div class="tab-pane fade show active" id="tab-profil">
                        <div class="bg-white rounded-2xl rounded-tl-none border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <form action="{{ route('user-profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="space-y-5">
                                        {{-- Foto Avatar --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                                Foto Profil
                                            </label>
                                            @php
                                                $avatarClass = $errors->has('avatar')
                                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                                            @endphp
                                            <input type="file" name="avatar"
                                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $avatarClass }} text-sm font-medium transition focus:outline-none focus:ring-4 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:text-xs file:font-semibold hover:file:bg-indigo-100"
                                                accept="image/*" onchange="previewAvatar(this)">
                                            @error('avatar')
                                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="mt-1.5 text-xs text-gray-400">Format: JPG, JPEG, PNG. Maks: 2MB</p>

                                            {{-- Preview foto --}}
                                            <div id="avatar-preview" class="hidden mt-3 items-center gap-2">
                                                <img id="preview-img" src=""
                                                    class="w-[60px] h-[60px] rounded-full object-cover border-2 border-[#1e3a5f]">
                                                <span class="text-xs text-gray-400">Preview foto baru</span>
                                            </div>
                                        </div>

                                        {{-- Nama --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
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

                                        {{-- Email (readonly) --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                                            <input type="email"
                                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 text-sm font-medium cursor-not-allowed"
                                                value="{{ $user->email }}" readonly>
                                            <p class="mt-1.5 text-xs text-gray-400">Email tidak bisa diubah</p>
                                        </div>

                                        {{-- No Telepon --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No.
                                                Telepon</label>
                                            @php
                                                $noTeleponClass = $errors->has('no_telepon')
                                                    ? 'border-red-400 bg-red-50/30 text-red-900 focus:ring-red-500/20 focus:border-red-500'
                                                    : 'border-gray-200 text-gray-800 bg-white focus:ring-indigo-500/20 focus:border-indigo-500';
                                            @endphp
                                            <div class="flex items-stretch">
                                                <span
                                                    class="inline-flex items-center px-3.5 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50 text-gray-400">
                                                    <i class="bi bi-phone"></i>
                                                </span>
                                                <input type="text" name="no_telepon"
                                                    class="w-full px-3.5 py-2.5 rounded-r-xl border {{ $noTeleponClass }} text-sm font-medium transition focus:outline-none focus:ring-4"
                                                    value="{{ old('no_telepon', $profile->no_telepon ?? '') }}"
                                                    placeholder="08123456789">
                                            </div>
                                            @error('no_telepon')
                                                <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Jenis Kelamin --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis
                                                Kelamin</label>
                                            <div class="flex gap-3">
                                                <label for="laki"
                                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                                    <input type="radio" name="jenis_kelamin" value="Laki-laki"
                                                        id="laki" class="accent-indigo-600"
                                                        {{ old('jenis_kelamin', $profile->jenis_kelamin ?? '') === 'Laki-laki' ? 'checked' : '' }}>
                                                    Laki-laki
                                                </label>
                                                <label for="perempuan"
                                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                                                        id="perempuan" class="accent-indigo-600"
                                                        {{ old('jenis_kelamin', $profile->jenis_kelamin ?? '') === 'Perempuan' ? 'checked' : '' }}>
                                                    Perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8 pt-6 border-t border-gray-100">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm hover:shadow transition active:scale-[0.98]">
                                            <i class="bi bi-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview foto sebelum upload
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('avatar-preview').classList.remove('hidden');
                    document.getElementById('avatar-preview').classList.add('flex');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle show/hide password
        function togglePass(fieldId, btn) {
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

        // Kalau ada error password, otomatis buka tab password
        @if ($errors->has('current_password') || $errors->has('password'))
            document.addEventListener('DOMContentLoaded', () => {
                const tab = document.querySelector('[data-bs-target="#tab-password"]');
                bootstrap.Tab.getOrCreateInstance(tab).show();
            });
        @endif
    </script>

@endsection
