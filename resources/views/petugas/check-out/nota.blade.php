<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Check-Out</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #3a352f;
            padding: 26px;
        }

        /* Header Hotel */
        .hotel-header {
            text-align: center;
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 2px solid #a9812f;
        }

        .hotel-name {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 24px;
            font-weight: 700;
            color: #2b2621;
            letter-spacing: 3px;
        }

        .hotel-sub {
            font-size: 10px;
            color: #8a7f6d;
            margin-top: 4px;
            letter-spacing: .5px;
        }

        /* Judul Nota */
        .nota-title {
            text-align: center;
            margin-bottom: 16px;
        }

        .nota-title h3 {
            font-size: 14px;
            font-weight: 700;
            color: #a9812f;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .nota-title p {
            font-size: 10px;
            color: #a39a89;
            margin-top: 3px;
        }

        /* Info Tamu */
        .info-box {
            background: #faf7f0;
            border: 1px solid #ece4d2;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: #8a7f6d;
        }

        .info-value {
            font-weight: 600;
            color: #2b2621;
            text-align: right;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px dashed #d8cdb6;
            margin: 14px 0;
        }

        /* Tabel rincian */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        thead th {
            background: #2b2621;
            color: #f3ead9;
            padding: 8px 10px;
            font-size: 10.5px;
            text-align: left;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        thead th:first-child {
            border-radius: 6px 0 0 0;
        }

        thead th:last-child {
            border-radius: 0 6px 0 0;
        }

        tbody td {
            padding: 9px 10px;
            font-size: 11px;
            border-bottom: 1px solid #ece4d2;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tfoot td {
            padding: 9px 10px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Kotak Total */
        .total-cell {
            background: #2b2621;
            color: #f3ead9;
            border-radius: 8px;
            padding: 14px 18px;
        }

        .total-cell-label {
            font-size: 10.5px;
            color: #cbb98c;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .total-cell-amount {
            font-size: 19px;
            font-weight: 700;
            margin-top: 3px;
            color: #f3ead9;
        }

        /* Status */
        .status-badge {
            background: #EAF3DE;
            color: #27500A;
            border: 1px solid #C0DD97;
            border-radius: 99px;
            padding: 4px 16px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
        }

        .ttd {
            text-align: center;
            width: 45%;
        }

        .ttd-title {
            font-size: 11px;
            margin-bottom: 50px;
        }

        .ttd-name {
            font-size: 11px;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        .thanks {
            text-align: center;
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px dashed #d8cdb6;
            font-size: 11px;
            color: #8a7f6d;
            font-style: italic;
        }

        /* Print info */
        .print-info {
            font-size: 9.5px;
            color: #c2b9a9;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    {{-- Header Hotel --}}
    <div class="hotel-header">
        <div class="hotel-name">NURA BOUTIQUE HOTEL</div>
        <div class="hotel-sub">Sistem Manajemen Hotel</div>
    </div>

    {{-- Judul Nota --}}
    <div class="nota-title">
        <h3>Nota Pembayaran</h3>
        <p>No. Booking #{{ $booking->id }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- Info Tamu --}}
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Nama Tamu</span>
            <span class="info-value">{{ $booking->tamu->nama_lengkap }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Identitas</span>
            <span class="info-value">{{ $booking->tamu->identity_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Telepon</span>
            <span class="info-value">{{ $booking->tamu->no_telepon }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Alamat</span>
            <span class="info-value">{{ $booking->tamu->alamat ?? '-' }}</span>
        </div>
    </div>

    <hr class="divider">

    {{-- Rincian Menginap --}}
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th style="text-align:center">Malam</th>
                <th style="text-align:right">Harga/Malam</th>
                <th style="text-align:right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Kamar {{ $booking->kamar->nomor_kamar }}</strong><br>
                    <span style="color:#8a7f6d;font-size:10px">
                        Tipe: {{ $booking->kamar->tipeKamar->nama_tipe_kamar }} ·
                        Kapasitas: {{ $booking->kamar->tipeKamar->kapasitas }} orang
                    </span>
                </td>
                <td style="text-align:center">{{ $booking->total_malam }}</td>
                <td style="text-align:right">
                    Rp {{ number_format($booking->kamar->tipeKamar->harga_per_malam, 0, ',', '.') }}
                </td>
                <td style="text-align:right;font-weight:600;color:#7a5f1e">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-size:10px;color:#8a7f6d;font-weight:400">
                    Check-In: {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                    &nbsp;&nbsp;
                    Check-Out: {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                </td>
                <td style="text-align:right;color:#8a7f6d;font-size:11px">TOTAL BAYAR</td>
                <td style="text-align:right;font-size:14px;color:#2b2621">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Kotak Total --}}
    <table style="margin-bottom:16px">
        <tr>
            <td class="total-cell" style="width:50%">
                <div class="total-cell-label">Total Pembayaran</div>
                <div class="total-cell-amount">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </div>
            </td>
            <td style="width:4%"></td>
            <td style="vertical-align:top;padding-left:8px;font-size:11px;color:#8a7f6d">
                <div>Status: <strong style="color:#27500A">LUNAS</strong></div>
                <div style="margin-top:5px">Ditangani oleh:</div>
                <div style="font-weight:600;color:#2b2621">
                    {{ $booking->handledBy->name ?? auth()->user()->name }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Catatan --}}
    @if ($booking->catatan)
        <div
            style="font-size:11px;color:#8a7f6d;margin-bottom:16px;background:#faf7f0;border:1px solid #ece4d2;border-radius:6px;padding:10px 14px">
            <strong style="color:#2b2621">Catatan:</strong> {{ $booking->catatan }}
        </div>
    @endif

    {{-- <hr class="divider"> --}}

    {{-- TTD --}}
    {{-- <div class="footer">
        <div class="footer-row">
            <div class="ttd">
                <div class="ttd-title">Tamu</div>
                <div class="ttd-name">{{ $booking->tamu->nama_lengkap }}</div>
            </div>
            <div class="ttd">
                <div class="ttd-title">Petugas Hotel</div>
                <div class="ttd-name">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </div> --}}

    {{-- Ucapan Terima Kasih --}}
    <div class="thanks">
        Terima kasih telah menginap di Nura Boutique Hotel<br>
        Kami berharap dapat melayani Anda kembali!
    </div>

</body>

</html>
