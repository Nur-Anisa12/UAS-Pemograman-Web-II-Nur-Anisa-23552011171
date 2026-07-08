@extends('layouts.app')
@section('page-title', 'Dashboard Petugas')
@section('content')

    @php
        $pending = \App\Models\Booking::where('status', 'pending')->count();
        $confirmed = \App\Models\Booking::where('status', 'confirmed')->count();
        $checkedIn = \App\Models\Booking::where('status', 'checked_in')->count();
        $checkedOut = \App\Models\Booking::where('status', 'checked_out')->count();
        $cancelled = \App\Models\Booking::where('status', 'cancelled')->count();
    @endphp

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="rounded-xl p-5 text-white shadow-sm" style="background: linear-gradient(135deg, #0F1B2D, #1a2d45)">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                    <i class="bi bi-calendar-check text-gold text-lg"></i>
                </div>
                <span
                    class="text-[11px] font-semibold uppercase tracking-wide text-white/50 bg-white/10 rounded-full px-2.5 py-1">Booking</span>
            </div>
            <div class="text-3xl font-bold leading-none mb-1">{{ $pending }}</div>
            <div class="text-xs text-white/60">Booking Pending</div>
        </div>

        <div class="rounded-xl p-5 text-white shadow-sm" style="background: linear-gradient(135deg, #9a7a2e, #C9A84C)">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="bi bi-box-arrow-in-right text-white text-lg"></i>
                </div>
                <span
                    class="text-[11px] font-semibold uppercase tracking-wide text-white/70 bg-white/20 rounded-full px-2.5 py-1">Check-In</span>
            </div>
            <div class="text-3xl font-bold leading-none mb-1">{{ $confirmed }}</div>
            <div class="text-xs text-white/80">Siap Check-In</div>
        </div>

        <div class="rounded-xl p-5 text-white shadow-sm" style="background: linear-gradient(135deg, #16243a, #2d4566)">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                    <i class="bi bi-people text-gold text-lg"></i>
                </div>
                <span
                    class="text-[11px] font-semibold uppercase tracking-wide text-white/50 bg-white/10 rounded-full px-2.5 py-1">Menginap</span>
            </div>
            <div class="text-3xl font-bold leading-none mb-1">{{ $checkedIn }}</div>
            <div class="text-xs text-white/60">Tamu Menginap</div>
        </div>

    </div>

    {{-- Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        {{-- Bar Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h6 class="text-navy font-semibold text-sm mb-4 flex items-center gap-2">
                <i class="bi bi-bar-chart-line text-gold"></i> Statistik Status Booking
            </h6>
            <canvas id="bookingBarChart" height="120"></canvas>
        </div>

        {{-- Doughnut Chart --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col">
            <h6 class="text-navy font-semibold text-sm mb-4 flex items-center gap-2">
                <i class="bi bi-pie-chart text-gold"></i> Proporsi Status
            </h6>
            <div class="flex-1 flex items-center">
                <canvas id="bookingDoughnutChart"></canvas>
            </div>
        </div>

    </div>

    {{-- Tabel Booking Perlu Diproses --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 pt-4 pb-3 border-b border-gray-100 flex items-center justify-between">
            <h6 class="text-navy font-semibold text-sm flex items-center gap-2 mb-0">
                <i class="bi bi-list-check text-gold"></i> Booking Perlu Diproses
            </h6>
            <span class="text-[11px] text-gray-400 font-medium">
                {{ \App\Models\Booking::whereIn('status', ['pending', 'confirmed', 'checked_in'])->count() }} entri
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[11px] tracking-wide">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">Tamu</th>
                        <th class="text-left px-5 py-3 font-semibold">Kamar</th>
                        <th class="text-left px-5 py-3 font-semibold">Check-In</th>
                        <th class="text-left px-5 py-3 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse(\App\Models\Booking::with(['Tamu','Kamar'])
                        ->whereIn('status', ['pending','confirmed','checked_in'])
                        ->latest()->take(8)->get() as $booking)
                        <tr class="hover:bg-amber-50/30 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-700">{{ $booking->Tamu->nama_lengkap }}</td>
                            <td class="px-5 py-3 text-gray-600">Kamar {{ $booking->Kamar->nomor_kamar }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $booking->check_in_date }}</td>
                            <td class="px-5 py-3">
                                @php
                                    $badgeStyles = [
                                        'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'confirmed' => 'bg-sky-50 text-sky-700 border border-sky-200',
                                        'checked_in' => 'bg-navy/5 text-navy border border-navy/20',
                                    ];
                                @endphp
                                <span
                                    class="inline-block text-[11px] font-semibold uppercase tracking-wide rounded-full px-2.5 py-1 {{ $badgeStyles[$booking->status] ?? 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <button
                                    class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-navy border border-navy/20 rounded-lg px-3 py-1.5 hover:bg-navy hover:text-white transition-colors">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-8">
                                <i class="bi bi-inbox text-2xl block mb-2 opacity-40"></i>
                                Tidak ada booking yang perlu diproses
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const labels = ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Cancelled'];
        const data = [{{ $pending }}, {{ $confirmed }}, {{ $checkedIn }}, {{ $checkedOut }},
            {{ $cancelled }}
        ];
        const palette = ['#C9A84C', '#4da3ff', '#0F1B2D', '#2daa6a', '#e05656'];

        new Chart(document.getElementById('bookingBarChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Jumlah Booking',
                    data,
                    backgroundColor: palette,
                    borderRadius: 6,
                    maxBarThickness: 42,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#f1f1f1'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('bookingDoughnutChart'), {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: palette,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>

@endsection
