<!DOCTYPE html>
<html lang="id" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hotel Reservasi' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── Sidebar ── */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #122946;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all .3s;
        }

        #sidebar .sidebar-brand {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        #sidebar .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 16px;
        }

        #sidebar .sidebar-brand small {
            color: rgb(219, 168, 40);
            font-size: 11px;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, .7);
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all .2s;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .1);
            border-left: 3px solid #4da3ff;
        }

        #sidebar .nav-section {
            padding: 14px 20px 6px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #a4a2a2;
            font-weight: 600;
        }

        /* ── Main Content ── */
        #main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f4f6f9;
        }

        /* ── Topbar ── */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e0e6ed;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a5f;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: #1e3a5f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
        }

        /* ── Page Content ── */
        .page-content {
            padding: 24px;
        }

        /* ── Cards ── */
        .stat-card {
            border: none;
            border-radius: 12px;
            padding: 20px;
            color: #fff;
        }

        .stat-card .stat-icon {
            font-size: 32px;
            opacity: .8;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin: 4px 0;
        }

        .stat-card .stat-label {
            font-size: 13px;
            opacity: .85;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar {
                left: -250px;
            }

            #sidebar.show {
                left: 0;
            }

            #main-content {
                margin-left: 0;
            }
        }

        /* ── CSS Variables Dark/Light Mode ── */
        :root {
            --bg-sidebar: #122946;
            --bg-main: #f4f6f9;
            --bg-topbar: #ffffff;
            --bg-card: #ffffff;
            --text-primary: #1e3a5f;
            --text-secondary: #666666;
            --border-color: #e0e6ed;
            --nav-link-color: rgba(255, 255, 255, .7);
            --nav-section: #a4a2a2;
        }

        html.dark {
            --bg-sidebar: #0d1f35;
            --bg-main: #0f172a;
            --bg-topbar: #1e293b;
            --bg-card: #1e293b;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --nav-link-color: rgba(255, 255, 255, .6);
            --nav-section: #64748b;
        }

        /* ── Terapkan variables ke elemen ── */
        body {
            background: var(--bg-main);
            color: var(--text-primary);
            transition: background .3s, color .3s;
        }

        #sidebar {
            background: var(--bg-sidebar) !important;
        }

        #sidebar .nav-section {
            color: var(--nav-section) !important;
        }

        #sidebar .nav-link {
            color: var(--nav-link-color) !important;
        }

        #topbar {
            background: var(--bg-topbar) !important;
            border-bottom-color: var(--border-color) !important;
        }

        .topbar-title {
            color: var(--text-primary) !important;
        }

        #main-content {
            background: var(--bg-main) !important;
        }

        /* Dark mode untuk Bootstrap components */
        html.dark .card {
            background: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        html.dark .table {
            --bs-table-bg: var(--bg-card);
            --bs-table-color: var(--text-primary);
            --bs-table-border-color: var(--border-color);
            --bs-table-hover-bg: #263548;
        }

        html.dark .table-light {
            --bs-table-bg: #1a2f45;
            --bs-table-color: var(--text-primary);
        }

        html.dark .form-control,
        html.dark .form-select {
            background: #1e293b;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        html.dark .form-control:focus,
        html.dark .form-select:focus {
            background: #1e293b;
            color: var(--text-primary);
            border-color: #4da3ff;
            box-shadow: 0 0 0 .25rem rgba(77, 163, 255, .25);
        }

        html.dark .form-control::placeholder {
            color: #64748b;
        }

        html.dark .btn-light {
            background: #1e293b;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        html.dark .btn-light:hover {
            background: #263548;
        }

        html.dark .dropdown-menu {
            background: #1e293b;
            border-color: var(--border-color);
        }

        html.dark .dropdown-item {
            color: var(--text-primary);
        }

        html.dark .dropdown-item:hover {
            background: #263548;
            color: #fff;
        }

        html.dark .dropdown-item-text {
            color: var(--text-secondary) !important;
        }

        html.dark .dropdown-divider {
            border-color: var(--border-color);
        }

        html.dark .alert {
            border-color: var(--border-color);
        }

        html.dark .input-group-text {
            background: #1e293b;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        html.dark .modal-content {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        html.dark .modal-header {
            border-color: var(--border-color);
        }

        html.dark .modal-footer {
            border-color: var(--border-color);
        }

        html.dark .text-muted {
            color: var(--text-secondary) !important;
        }

        html.dark .border,
        html.dark .card-footer,
        html.dark .card-header {
            border-color: var(--border-color) !important;
        }

        html.dark .bg-light {
            background: #1a2f45 !important;
        }

        html.dark hr {
            border-color: var(--border-color);
        }

        html.dark .pagination .page-link {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        html.dark .pagination .page-item.active .page-link {
            background: #1e3a5f;
            border-color: #1e3a5f;
        }
    </style>
</head>

<body>

    {{-- ══ SIDEBAR ══ --}}
    <div id="sidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <h5><i class="bi bi-flower1"></i> Nura Boutique Hotel</h5>
            <small>Management System</small>
        </div>

        {{-- Menu berdasarkan role --}}
        <nav class="mt-2">
            @if (auth()->user()->role === 'admin')
                {{-- MENU ADMIN --}}
                <div class="nav-section">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="nav-section">Master Data</div>
                <a href="{{ route('admin.tipe-kamar.index') }}"
                    class="nav-link {{ request()->routeIs('admin.tipe-kamar.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i> Tipe Kamar
                </a>
                <a href="{{ route('admin.fasilitas.index') }}"
                    class="nav-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                    <i class="bi bi-stars"></i> Fasilitas
                </a>
                <a href="{{ route('admin.kamar.index') }}"
                    class="nav-link {{ request()->routeIs('admin.kamar.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i> Data Kamar
                </a>

                <div class="nav-section">Operasional</div>
                <a href="{{ route('admin.tamu.index') }}"
                    class="nav-link {{ request()->routeIs('admin.tamu.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Tamu
                </a>
                <a href="{{ route('admin.bookings.index') }}"
                    class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Booking
                </a>

                <div class="nav-section">Laporan</div>
                <a href="{{ route('admin.laporan.index') }}"
                    class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Reservasi
                </a>

                <div class="nav-section">Pengaturan</div>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Kelola User
                </a>
                <a href="{{ route('admin.activity-log.index') }}"
                    class="nav-link {{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Log Activity
                </a>
            @else
                {{-- MENU PETUGAS --}}
                <div class="nav-section">Dashboard</div>
                <a href="{{ route('petugas.dashboard') }}"
                    class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="nav-section">Operasional</div>
                <a href="{{ route('petugas.tamu.index') }}"
                    class="nav-link {{ request()->routeIs('petugas.tamu.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Tamu
                </a>
                <a href="{{ route('petugas.bookings.index') }}"
                    class="nav-link {{ request()->routeIs('petugas.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Bookings
                </a>
                {{-- Check-In dengan badge jumlah --}}
                <a href="{{ route('petugas.checkin.index') }}"
                    class="nav-link {{ request()->routeIs('petugas.checkin.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-right"></i> Check-In
                    @php $jumlahCheckin = \App\Models\Booking::where('status','confirmed')->count(); @endphp
                    @if ($jumlahCheckin > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $jumlahCheckin }}</span>
                    @endif
                </a>
                {{-- Check-Out dengan badge jumlah --}}
                <a href="{{ route('petugas.checkout.index') }}"
                    class="nav-link {{ request()->routeIs('petugas.checkout.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-right"></i> Check-Out
                    @php $jumlahCheckout = \App\Models\Booking::where('status','checked_in')->count(); @endphp
                    @if ($jumlahCheckout > 0)
                        <span class="badge bg-danger ms-auto">{{ $jumlahCheckout }}</span>
                    @endif
                </a>
            @endif
        </nav>

        {{-- User info di bawah sidebar --}}
        <div style="position:absolute;bottom:0;width:100%;padding:16px;border-top:1px solid rgba(255,255,255,.1)">
            <div style="display:flex;align-items:center;gap:10px">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <div style="color:#fff;font-size:13px;font-weight:500">{{ auth()->user()->name }}</div>
                    <div style="color:rgba(255,255,255,.5);font-size:11px;text-transform:capitalize">
                        {{ auth()->user()->role }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN CONTENT ══ --}}
    <div id="main-content">

        {{-- Topbar --}}
        <div id="topbar">
            <div style="display:flex;align-items:center;gap:12px">
                {{-- Tombol toggle sidebar (mobile) --}}
                <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h6 class="topbar-title">@yield('page-title', 'Dashboard')</h6>
            </div>

            <div class="user-info">
                <span class="badge bg-primary text-capitalize">{{ auth()->user()->role }}</span>
                <span style="font-size:13px;color:#666">{{ auth()->user()->name }}</span>

                {{-- TAMBAH TOMBOL DARK MODE INI ↓ --}}
                <button onclick="toggleDarkMode()" id="dark-toggle" class="btn btn-sm btn-light"
                    title="Toggle Dark Mode"
                    style="width:34px;height:34px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:50%">
                    <i class="bi bi-moon-fill" id="dark-icon"></i>
                </button>


                {{-- Dropdown logout --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted" style="font-size:12px">
                                {{ auth()->user()->email }}
                            </span></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="{{ route('user-profile.index') }}" class="dropdown-item">
                                <i class="bi bi-person-circle"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="/logout">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ── Sidebar toggle (mobile) ──
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // ── Dark Mode ──
        const htmlRoot = document.getElementById('html-root');
        const darkIcon = document.getElementById('dark-icon');

        // Cek preference yang tersimpan
        function applyDarkMode(isDark) {
            if (isDark) {
                htmlRoot.classList.add('dark');
                darkIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
                darkIcon.style.color = '#fbbf24'; // kuning
            } else {
                htmlRoot.classList.remove('dark');
                darkIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
                darkIcon.style.color = '';
            }
        }

        // Load preference dari localStorage saat halaman dibuka
        const savedMode = localStorage.getItem('darkMode');
        applyDarkMode(savedMode === 'true');

        // Toggle saat tombol diklik
        function toggleDarkMode() {
            const isDark = !htmlRoot.classList.contains('dark');
            localStorage.setItem('darkMode', isDark);
            applyDarkMode(isDark);
        }
    </script>
    @stack('scripts')
</body>

</html>
