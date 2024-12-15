@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <div class="row">

        <!-- Total Pegawai -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pegawai Perusahaan A</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalPegawai }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pegawai Hadir Hari Ini -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pegawai yang Masuk</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $pegawaiHadirHariIni }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Perizinan Pending -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Perizinan yang Pending</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $perizinanPending }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Countdown Hari Kerja -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Countdown Hari</p>
                                <h5 class="font-weight-bolder mb-0" id="countdown-timer">
                                    00:00:00 <!-- Countdown will be updated using JavaScript -->
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="ni ni-album-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Rentang Waktu -->
        <div class="col-md-12 mb-4">
            <select id="time-range-filter" class="form-control">
                <option value="daily" {{ request('range') == 'daily' ? 'selected' : '' }}>Harian</option>
                <option value="weekly" {{ request('range') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                <option value="monthly" {{ request('range') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        <!-- Grafik Absensi -->
        <div class="col-md-6 mb-4">
            <h4 style="text-align: center;">Grafik Absensi</h4>
            <canvas id="absensi-bar-chart" class="chart-canvas"></canvas>
        </div>
        
        <!-- Grafik Persentase Status Izin -->
        <div class="col-md-6 mb-4">
            <h4 style="text-align: center;">Persentase Status Izin</h4>
            <canvas id="izin-pie-chart" class="chart-canvas"></canvas>
        </div>
    </div>
</div>
@endsection

@push('dashboard')
<style>
    .chart-canvas {
        width: 100% !important;  
        height: 300px !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;  /* Make each graph take full width on smaller screens */
            max-width: 100%;
        }

        .col-xl-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<script>
    window.onload = function() {
        // Filter Rentang Waktu
        document.getElementById("time-range-filter").addEventListener("change", function() {
            var selectedRange = this.value;
            window.location.href = '/hrd/dashboard?range=' + selectedRange;  // Kirim filter ke backend
        });

        // Grafik Absensi
        var ctx = document.getElementById("absensi-bar-chart").getContext("2d");

        // Ambil data label berdasarkan range
        var absensiLabels = @json($absensiLabels);
        var hadirData = @json($absensi->pluck('hadir'));
        var izinData = @json($absensi->pluck('izin'));
        var sakitData = @json($absensi->pluck('sakit'));

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: absensiLabels,
                datasets: [
                    {
                        label: "Hadir",
                        data: hadirData,
                        backgroundColor: "#006FFD", // Biru
                    },
                    {
                        label: "Izin",
                        data: izinData,
                        backgroundColor: "#FF8C00", // Oren Gelap
                    },
                    {
                        label: "Sakit",
                        data: sakitData,
                        backgroundColor: "#B0BEC5", // Abu-abu
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                        },
                    },
                },
            }
        });

        // Grafik Persentase Status Izin
        var ctx2 = document.getElementById("izin-pie-chart").getContext("2d");

        var izinStatusLabels = @json($izinStatus->pluck('status_izin'));
        var izinStatusCounts = @json($izinStatus->pluck('count'));

        new Chart(ctx2, {
            type: "pie",
            data: {
                labels: izinStatusLabels,
                datasets: [{
                    data: izinStatusCounts,
                    backgroundColor: ["#6abf69", "#f28b82", "#a7c6ed"], // Hijau, Merah Muda, Biru Muda
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });

        // Countdown Hari Kerja
        function updateCountdown() {
            var now = new Date();
            var endOfWorkday = new Date();
            endOfWorkday.setHours(17, 0, 0, 0);  // Set the workday end time (5 PM)

            // Check if it's during working hours (Mon to Fri)
            if (now.getDay() >= 1 && now.getDay() <= 5) {
                var remainingTime = endOfWorkday - now;
                if (remainingTime > 0) {
                    var hours = Math.floor(remainingTime / (1000 * 60 * 60));
                    var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                    
                    // Format and display the remaining time
                    document.getElementById("countdown-timer").innerHTML =
                      ("0" + hours).slice(-2) + ":" +
                      ("0" + minutes).slice(-2) + ":" +
                      ("0" + seconds).slice(-2);
                } else {
                    document.getElementById("countdown-timer").innerHTML = "00:00:00";
                }
            } else {
                document.getElementById("countdown-timer").innerHTML = "Libur";
            }
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown();  // Call once to initialize
    }
</script>
@endpush
