<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Pasien Hari Ini -->
        <div class="col-md-{{ auth()->user()->role === 'Dokter' ? '12' : '4' }} mb-4">
            <div class="card shadow border-0 h-100 py-2" style="border-left: .25rem solid #4e73df !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kunjungan Pasien (Hari Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalPatientsToday }} Pasien
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-group fa-2x text-gray-300" style="font-size: 2.5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role !== 'Dokter')
            <!-- Pendapatan Hari Ini -->
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 h-100 py-2" style="border-left: .25rem solid #1cc88a !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pendapatan (Hari Ini)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($dailyRevenue, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-money fa-2x text-gray-300" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 h-100 py-2" style="border-left: .25rem solid #36b9cc !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pendapatan (Bulan Ini)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-wallet fa-2x text-gray-300" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Grafik Mingguan -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Tren Kunjungan (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="position: relative; height:400px; width:100%">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('myAreaChart').getContext('2d');
            
            const labels = {!! json_encode(array_keys($weeklyVisits)) !!};
            const data = {!! json_encode(array_values($weeklyVisits)) !!};
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Kunjungan",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: data,
                        fill: true,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyColor: "#858796",
                            titleMarginBottom: 10,
                            titleColor: '#6e707e',
                            titleFont: { size: 14 },
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app>
