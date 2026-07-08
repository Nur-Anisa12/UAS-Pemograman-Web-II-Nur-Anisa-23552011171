<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi Hotel - Nura Boutique Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .hotel-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a5f;
            letter-spacing: 0.5px;
        }

        .hotel-tagline {
            font-size: 10px;
            color: #999;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .report-title {
            text-align: right;
        }

        .report-title h2 {
            font-size: 15px;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .report-title p {
            font-size: 10px;
            color: #666;
            line-height: 1.5;
        }

        /* Filter info */
        .filter-info {
            background: #f4f6f9;
            border-left: 3px solid #1e3a5f;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 11px;
            color: #555;
        }

        .filter-info span {
            font-weight: bold;
            color: #1e3a5f;
        }

        /* Statistik */
        .stats-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .stats-table td {
            padding: 0 4px;
        }

        .stats-table td:first-child {
            padding-left: 0;
        }

        .stats-table td:last-child {
            padding-right: 0;
        }

        .stat-box {
            border-radius: 6px;
            padding: 12px 10px;
            text-align: center;
            color: #fff;
        }

        .stat-box .num {
            font-size: 18px;
            font-weight: bold;
        }

        .stat-box .lbl {
            font-size: 9px;
            opacity: .9;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-total {
            background: #1e3a5f;
        }

        .bg-revenue {
            background: #1a7a4a;
        }

        .bg-checkin {
            background: #c87d2a;
        }

        .bg-cancel {
            background: #a32d2d;
        }

        /* Tabel */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .data-table thead tr {
            background: #1e3a5f;
            color: #fff;
        }

        .data-table thead th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            letter-spacing: 0.3px;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f4f6f9;
        }

        .data-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .data-table tbody td {
            padding: 7px 6px;
            font-size: 10px;
            border-bottom: 1px solid #e0e6ed;
        }

        .data-table tfoot tr {
            background: #1e3a5f;
            color: #fff;
        }

        .data-table tfoot td {
            padding: 8px 6px;
            font-size: 10px;
            font-weight: bold;
        }

        /* Status badge */
        .badge {
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-pending {
            background: #ffc107;
            color: #333;
        }

        .badge-confirmed {
            background: #17a2b8;
            color: #fff;
        }

        .badge-checked_in {
            background: #007bff;
            color: #fff;
        }

        .badge-checked_out {
            background: #28a745;
            color: #fff;
        }

        .badge-cancelled {
            background: #dc3545;
            color: #fff;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #888;
        }

        .footer-table td {
            vertical-align: top;
        }

        .ttd {
            text-align: right;
        }

        .ttd p {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width:55%">
                <div class="hotel-name">Nura Boutique Hotel</div>
                <div class="hotel-tagline">Comfort &amp; Elegance</div>
            </td>
            <td class="report-title" style="width:45%">
                <h2>LAPORAN RESERVASI</h2>
                <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</p>
                <p>Dicetak oleh: {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>
            </td>
        </tr>
    </table>

    <!-- Info Filter -->
    <div class="filter-info">
        Periode:
        <span>{{ $dari ? \Carbon\Carbon::parse($dari)->format('d M Y') : 'Semua' }}</span>
        s/d
        <span>{{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d M Y') : 'Sekarang' }}</span>
        &nbsp;|&nbsp; Status: <span>{{ $status ? strtoupper($status) : 'Semua' }}</span>
        &nbsp;|&nbsp; Total Data: <span>{{ $bookings->count() }} reservasi</span>
    </div>

    <!-- Statistik -->
    <table class="stats-table">
        <tr>
            <td style="width:25%">
                <div class="stat-box bg-total">
                    <div class="num">{{ $bookings->count() }}</div>
                    <div class="lbl">Total Booking</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="stat-box bg-revenue">
                    <div class="num" style="font-size:14px">
                        Rp
                        {{ number_format($bookings->where('status', 'checked_out')->sum('total_harga'), 0, ',', '.') }}
                    </div>
                    <div class="lbl">Total Pendapatan</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="stat-box bg-checkin">
                    <div class="num">{{ $bookings->where('status', 'checked_in')->count() }}</div>
                    <div class="lbl">Tamu Menginap</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="stat-box bg-cancel">
                    <div class="num">{{ $bookings->where('status', 'cancelled')->count() }}</div>
                    <div class="lbl">Dibatalkan</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Tabel Data -->
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Tipe</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Malam</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $i => $booking)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        {{ $booking->tamu->nama_lengkap }}<br>
                        <span style="color:#888;font-size:9px">{{ $booking->tamu->identity_number }}</span>
                    </td>
                    <td style="font-weight:bold">{{ $booking->kamar->nomor_kamar }}</td>
                    <td>{{ $booking->kamar->tipeKamar->nama_tipe_kamar }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</td>
                    <td style="text-align:center">{{ $booking->total_malam }}</td>
                    <td style="font-weight:bold;color:#1a7a4a">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $booking->status }}">
                            {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:20px;color:#888">
                        Tidak ada data reservasi
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($bookings->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align:right">TOTAL PENDAPATAN (Checked Out):</td>
                    <td colspan="2">
                        Rp
                        {{ number_format($bookings->where('status', 'checked_out')->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Footer TTD -->
    <table class="footer-table">
        <tr>
            <td style="width:60%">
                <p>*Laporan ini digenerate otomatis oleh sistem Nura Boutique Hotel</p>
            </td>
            <td class="ttd" style="width:40%">
                <p>{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <p style="border-top:1px solid #333;padding-top:4px;margin-top:40px">
                    {{ auth()->user()->name }}
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
