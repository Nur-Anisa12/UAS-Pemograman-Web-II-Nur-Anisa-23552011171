<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Staf — Nura Boutique Hotel</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            DEFAULT: '#0F1B2D',
                            hover: '#1a2d45',
                        },
                        gold: {
                            DEFAULT: '#C9A84C',
                            light: 'rgba(201, 168, 76, 0.12)',
                            dark: '#9a7a2e',
                        },
                        cream: '#F8F4ED',
                        muted: '#8BA0B8',
                    },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .panel-pattern {
            background-image: repeating-linear-gradient(45deg, #C9A84C 0px, #C9A84C 1px, transparent 1px, transparent 20px);
        }

        .hotel-image {
            background-image:
                linear-gradient(180deg, rgba(15, 27, 45, 0.55) 0%, rgba(15, 27, 45, 0.35) 35%, rgba(15, 27, 45, 0.55) 70%, rgba(15, 27, 45, 0.8) 100%),
                url('https://images.pexels.com/photos/15489341/pexels-photo-15489341.jpeg?cs=srgb&q=85&w=2000&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .input-focus:focus-within {
            border-color: #C9A84C;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
        }

        .gold-line {
            transition: width 0.3s ease;
        }

        .btn-login:hover .gold-line {
            width: 34px;
        }
    </style>
</head>

<body class="min-h-screen">

    <x-auth-session-status :status="session('status')" />

    {{-- ===== BACKGROUND FULL-SCREEN FOTO HOTEL ===== --}}
    <div class="hotel-image relative min-h-screen w-full flex items-center justify-end px-4 sm:px-10 lg:px-16 py-10">

        <div class="absolute inset-0 bg-black/35"></div>

        {{-- Logo mengambang — pojok kiri atas --}}
        <div class="absolute top-8 left-6 sm:left-10 z-10 flex items-center gap-3">
            <div
                class="w-11 h-11 border border-gold/80 rounded-md flex items-center justify-center shrink-0 bg-navy/40 backdrop-blur-sm">
                <i class="ti ti-flower text-[#C9A84C] text-xl"></i>
            </div>
            <div>
                <div class="font-serif text-white text-base font-medium tracking-wider drop-shadow">Nura</div>
                <div class="text-[10px] text-white/80 tracking-[0.15em] uppercase mt-0.5 drop-shadow">Boutique
                    Hotel
                </div>
            </div>
        </div>

        {{-- Tagline — di tengah antara logo dan footer --}}
        <div class="absolute top-1/2 -translate-y-1/2 left-6 sm:left-10 z-10 max-w-sm">
            <div class="w-11 h-0.5 bg-gold mb-5"></div>
            <h2 class="font-serif text-white text-3xl sm:text-4xl font-medium leading-snug mb-3 drop-shadow">
                Portal Manajemen<br>Nura Boutique Hotel
            </h2>
            <p class="text-white/80 text-sm font-light leading-relaxed mb-6 max-w-sm drop-shadow">
                Sistem terpusat untuk mengelola operasional hotel, reservasi tamu, dan laporan harian secara
                efisien.
            </p>
            <ul class="space-y-0.5">
                <li class="flex items-center gap-3 py-2.5 border-b border-white/15 text-white/90 text-sm">
                    <i class="ti ti-calendar-event text-gold text-base shrink-0"></i>
                    Kelola reservasi &amp; ketersediaan kamar
                </li>
                <li class="flex items-center gap-3 py-2.5 border-b border-white/15 text-white/90 text-sm">
                    <i class="ti ti-users text-gold text-base shrink-0"></i>
                    Manajemen data tamu &amp; check-in/out
                </li>
                <li class="flex items-center gap-3 py-2.5 border-b border-white/15 text-white/90 text-sm">
                    <i class="ti ti-chart-bar text-gold text-base shrink-0"></i>
                    Laporan pendapatan &amp; okupansi
                </li>
                <li class="flex items-center gap-3 py-2.5 text-white/90 text-sm">
                    <i class="ti ti-settings text-gold text-base shrink-0"></i>
                    Pengaturan fasilitas &amp; layanan hotel
                </li>
            </ul>
        </div>

        {{-- Copyright mengambang — pojok kiri bawah --}}
        <p class="absolute bottom-8 left-6 sm:left-10 z-10 text-[11px] text-white/70 tracking-wide drop-shadow">
            © {{ date('Y') }} Nura Boutique Hotel. Akses terbatas untuk staf resmi.
        </p>

        {{-- ===== CARD LOGIN — MELAYANG, ROUNDED, SHADOW ===== --}}
        <div class="relative z-10 w-full max-w-[420px] bg-white rounded-2xl shadow-2xl px-6 sm:px-10 py-10 sm:py-12">

            {{-- Badge --}}
            <div class="mb-5 flex justify-center">
                <span
                    class="inline-flex items-center gap-1.5 bg-gold-light border border-gold/30 text-gold-dark text-[11px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-full">
                    <i class="ti ti-shield-lock text-[13px]"></i>
                    Akses Petugas &amp; Admin
                </span>
            </div>

            <h1 class="font-serif text-2xl sm:text-[28px] font-bold text-navy mb-2 text-center uppercase">Portal Staf</h1>
            <p class="text-sm text-gray-500 font-light mb-6 text-center">Gunakan akun yang diberikan oleh manajemen hotel</p>

            {{-- Ornament --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <div class="w-1.5 h-1.5 bg-gold rotate-45 shrink-0"></div>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email / Username --}}
                <div class="mb-4">
                    <label class="block text-[10px] tracking-[0.1em] uppercase text-gray-500 font-semibold mb-2"
                        for="email">
                        Email Staf
                    </label>
                    <div
                        class="flex items-stretch input-focus border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                        <span
                            class="flex items-center justify-center w-12 bg-gray-50 text-gray-400 text-lg border-r border-gray-200">
                            <i class="ti ti-id-badge"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="email@nurahotel.com"
                            class="flex-1 h-12 px-3 bg-transparent text-sm placeholder-gray-400 focus:outline-none {{ $errors->has('password') ? 'text-red-600' : 'text-gray-900' }}"
                            required autofocus autocomplete="username" />
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="block text-[10px] tracking-[0.1em] uppercase text-gray-500 font-semibold mb-2"
                        for="password">
                        Kata Sandi
                    </label>
                    <div
                        class="flex items-stretch input-focus border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                        <span
                            class="flex items-center justify-center w-12 bg-gray-50 text-gray-400 text-lg border-r border-gray-200">
                            <i class="ti ti-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi"
                            class="flex-1 h-12 px-3 bg-transparent text-sm placeholder-gray-400 focus:outline-none {{ $errors->has('password') ? 'text-red-600' : 'text-gray-900' }}"
                            required autocomplete="current-password" />
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer select-none">
                        <input class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold focus:ring-offset-0"
                            type="checkbox" name="remember" id="remember_me">
                        <span class="text-[13px] text-gray-500">Ingat perangkat ini</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-gold hover:opacity-75 transition-opacity">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                {{-- Tombol Login --}}
                <button type="submit"
                    class="btn-login w-full h-[50px] bg-navy hover:bg-navy-hover text-cream text-xs font-semibold tracking-[0.12em] uppercase rounded-lg flex items-center justify-center gap-3 transition-colors mb-6">
                    Login
                    <i class="ti ti-arrow-right"></i>
                </button>

                {{-- Notif keamanan --}}
                <div
                    class="flex items-start gap-2.5 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-xs text-gray-500">
                    <i class="ti ti-info-circle text-gold text-base shrink-0 mt-0.5"></i>
                    <span>Akun ini hanya untuk petugas dan admin resmi Nura Boutique Hotel. Hubungi IT support jika
                        mengalami kendala masuk.</span>
                </div>

            </form>

        </div>

    </div>

</body>

</html>
