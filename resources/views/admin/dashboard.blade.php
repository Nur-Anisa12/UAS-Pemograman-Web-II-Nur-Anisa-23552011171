@extends('layouts.app')
@section('page-title', 'Dashboard Admin')
@section('content')

    @php
        $totalKamar = \App\Models\Kamar::count();
        $totalTamu = \App\Models\Tamu::count();
        $bookingAktif = \App\Models\Booking::whereIn('status', ['confirmed', 'checked_in'])->count();
        $kamarTersedia = \App\Models\Kamar::where('status', 'available')->count();
        $bookingTerbaru = \App\Models\Booking::with(['Tamu', 'Kamar'])
            ->latest()
            ->take(5)
            ->get();

        // Data tambahan untuk grafik (tidak mengubah logic, hanya query agregasi untuk visualisasi)
        $statusCounts = \App\Models\Booking::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusLabels = ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'];
        $statusData = collect($statusLabels)->map(fn($s) => $statusCounts[$s] ?? 0);

        $bookingPerBulan = \App\Models\Booking::selectRaw('MONTH(created_at) as bulan, count(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bookingChartData = collect(range(1, 12))->map(fn($b) => $bookingPerBulan[$b] ?? 0);
    @endphp

    <div class="space-y-6">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-blue-400 p-5 text-white shadow-lg shadow-blue-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Total Kamar</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight">{{ $totalKamar }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="bi bi-door-open text-xl"></i>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 h-20 w-20 rounded-full bg-white/10"></div>
            </div>

            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-400 p-5 text-white shadow-lg shadow-emerald-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-emerald-100">Total Tamu</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight">{{ $totalTamu }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="bi bi-people text-xl"></i>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 h-20 w-20 rounded-full bg-white/10"></div>
            </div>

            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-600 to-amber-400 p-5 text-white shadow-lg shadow-amber-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-amber-100">Booking Aktif</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight">{{ $bookingAktif }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="bi bi-calendar-check text-xl"></i>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 h-20 w-20 rounded-full bg-white/10"></div>
            </div>

            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-600 to-rose-400 p-5 text-white shadow-lg shadow-rose-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-rose-100">Kamar Tersedia</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight">{{ $kamarTersedia }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="bi bi-door-closed text-xl"></i>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 h-20 w-20 rounded-full bg-white/10"></div>
            </div>

        </div>

        {{-- Grafik --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <div class="lg:col-span-2 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <div class="mb-4 flex items-center justify-between">
                    <h6 class="text-sm font-semibold text-gray-700">
                        <i class="bi bi-bar-chart-line text-blue-500"></i> Booking per Bulan ({{ now()->year }})
                    </h6>
                </div>
                <canvas id="bookingPerBulanChart" height="110"></canvas>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <div class="mb-4 flex items-center justify-between">
                    <h6 class="text-sm font-semibold text-gray-700">
                        <i class="bi bi-pie-chart text-emerald-500"></i> Status Booking
                    </h6>
                </div>
                <canvas id="statusBookingChart" height="180"></canvas>
            </div>

        </div>

        {{-- Tabel Booking Terbaru --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 px-5 py-4">
                <h6 class="text-sm font-semibold text-gray-700">
                    <i class="bi bi-clock-history text-blue-500"></i> Booking Terbaru
                </h6>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Tamu</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Kamar</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Check-In</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Check-Out</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Total</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookingTerbaru as $booking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $booking->Tamu->nama_lengkap }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $booking->Kamar->nomor_kamar }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $booking->check_in_date }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $booking->check_out_date }}</td>
                                <td class="px-5 py-3 text-gray-600">Rp
                                    {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'confirmed' => 'bg-sky-100 text-sky-700',
                                            'checked_in' => 'bg-indigo-100 text-indigo-700',
                                            'checked_out' => 'bg-emerald-100 text-emerald-700',
                                            'cancelled' => 'bg-rose-100 text-rose-700',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-6 text-center text-gray-400">Belum ada booking</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Grafik Booking per Bulan
                new Chart(document.getElementById('bookingPerBulanChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bulanLabels) !!},
                        datasets: [{
                            label: 'Jumlah Booking',
                            data: {!! json_encode($bookingChartData) !!},
                            backgroundColor: '#3b82f6',
                            borderRadius: 6,
                            maxBarThickness: 28
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
                                    color: '#f1f5f9'
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

                // Grafik Status Booking
                new Chart(document.getElementById('statusBookingChart'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($statusLabels) !!},
                        datasets: [{
                            data: {!! json_encode($statusData) !!},
                            backgroundColor: ['#f59e0b', '#0ea5e9', '#6366f1', '#10b981', '#f43f5e'],
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
                                    padding: 12,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            });
        </script>
    @endpush

@endsection
