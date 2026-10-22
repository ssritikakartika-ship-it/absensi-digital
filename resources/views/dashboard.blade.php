<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Absensi Digital</title>

    @vite(['resources/css/absensi.css'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <i class="fa-solid fa-sparkles"></i>
            Absensi
        </div>

        <p class="sidebar-title">MENU</p>

        <a href="/dashboard" class="menu active">
            <i class="fa-solid fa-border-all"></i>
            Dashboard
        </a>

        <a href="/siswa" class="menu">
            <i class="fa-solid fa-user-graduate"></i>
            Data Siswa
        </a>

        <a href="/kelas" class="menu">
            <i class="fa-solid fa-school"></i>
            Data Kelas
        </a>

        <a href="/lokasi-qr" class="menu">
            <i class="fa-solid fa-location-dot"></i>
            Lokasi QR
        </a>

        <a href="/token-qr" class="menu">
            <i class="fa-solid fa-qrcode"></i>
            Token QR
        </a>

        <a href="/absensi" class="menu">
            <i class="fa-solid fa-clipboard-user"></i>
            Data Absensi
        </a>

        <a href="/laporan" class="menu">
            <i class="fa-solid fa-file-lines"></i>
            Laporan
        </a>

        <a href="/notifikasi" class="menu">
            <i class="fa-solid fa-bell"></i>
            Notifikasi
        </a>

        <a href="/setting" class="menu">
            <i class="fa-solid fa-gear"></i>
            Setting
        </a>

        <a href="/login" class="menu logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div>
                <h1>Dashboard</h1>
                <p>Selamat datang di Absensi Digital</p>
            </div>

            <div class="top-right">

                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search">
                </div>

                <div class="notification">
                    <i class="fa-solid fa-bell"></i>
                    <span>1</span>
                </div>

                <div class="profile">

                    <div class="profile-icon">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>

                    <div>
                        <strong>Admin User</strong>
                        <small>admin@gmail.com</small>
                    </div>

                </div>

            </div>

        </header>


        <!-- FILTER -->
        <div class="filter-area">

            <div class="date-box">
                <i class="fa-regular fa-calendar-days"></i>
                <input type="date" id="startDate">
            </div>

            <div class="date-box">
                <i class="fa-regular fa-calendar-days"></i>
                <input type="date" id="endDate">
            </div>

            <button class="filter-btn" onclick="filterDate()">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

        </div>


        <!-- STATISTICS -->
        <section class="stats">

            <!-- TOTAL SISWA -->
            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <span>Total Siswa</span>

                    <h2>
                        {{ $totalSiswa }}
                    </h2>
                </div>

            </div>


            <!-- HADIR -->
            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div>
                    <span>Hadir</span>

                    <h2>
                        {{ $hadir }}
                    </h2>
                </div>

            </div>


            <!-- BELUM HADIR -->
            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-user-clock"></i>
                </div>

                <div>
                    <span>Belum Hadir</span>

                    <h2>
                        {{ $belumHadir }}
                    </h2>
                </div>

            </div>


            <!-- PERSENTASE -->
            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <div>
                    <span>Persentase</span>

                    <h2>
                        {{ $persentase }}%
                    </h2>
                </div>

            </div>

        </section>


        <!-- CHART SECTION -->
        <section class="charts">

            <!-- BAR CHART -->
            <div class="chart-card large">

                <div class="card-header">

                    <div>
                        <h3>Statistik Absensi</h3>
                        <p>Data kehadiran siswa 7 hari terakhir</p>
                    </div>

                    <div class="chart-filter">

                        <button class="selected">
                            Week
                        </button>

                        <button>
                            Month
                        </button>

                        <button>
                            Year
                        </button>

                    </div>

                </div>

                <canvas id="attendanceChart"></canvas>

            </div>


            <!-- DOUGHNUT CHART -->
            <div class="chart-card">

                <div class="card-header">

                    <div>
                        <h3>Status Kehadiran</h3>

                        <p>
                            Hari ini
                        </p>
                    </div>

                </div>

                <canvas id="statusChart"></canvas>


                <div class="legend">

                    <div>
                        <span class="dot hadir"></span>
                        Hadir
                        <strong>{{ $hadir }}</strong>
                    </div>

                    <div>
                        <span class="dot izin"></span>
                        Izin
                        <strong>{{ $jumlahIzin }}</strong>
                    </div>

                    <div>
                        <span class="dot sakit"></span>
                        Sakit
                        <strong>{{ $jumlahSakit }}</strong>
                    </div>

                    <div>
                        <span class="dot alpha"></span>
                        Alpha
                        <strong>{{ $jumlahAlpha }}</strong>
                    </div>

                </div>

            </div>

        </section>


        <!-- RECENT ATTENDANCE -->
        <section class="bottom-section">


            <!-- ABSENSI TERBARU -->
            <div class="recent-card">

                <div class="card-header">

                    <div>

                        <h3>
                            Absensi Terbaru
                        </h3>

                        <p>
                            Data absensi siswa terbaru
                        </p>

                    </div>

                    <div class="small-search">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </div>

                </div>


                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>Siswa</th>

                                <th>Kelas</th>

                                <th>Tanggal</th>

                                <th>Check-In</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($recentAttendances as $attendance)

                            <tr>

                                <!-- SISWA -->
                                <td>

                                    <div class="student">

                                        <div class="avatar">

                                            {{ strtoupper(substr($attendance->student->nama ?? 'S', 0, 1)) }}

                                        </div>

                                        {{ $attendance->student->nama ?? 'Siswa' }}

                                    </div>

                                </td>


                                <!-- KELAS -->
                                <td>

                                    {{ $attendance->student->class->nama_kelas ?? '-' }}

                                </td>


                                <!-- TANGGAL -->
                                <td>

                                    {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d/m/Y') }}

                                </td>


                                <!-- WAKTU -->
                                <td>

                                    {{ $attendance->waktu ?? '-' }}

                                </td>


                                <!-- STATUS -->
                                <td>

                                    @if($attendance->status === 'hadir')

                                        <span class="status hadir-status">
                                            Hadir
                                        </span>

                                    @elseif($attendance->status === 'izin')

                                        <span class="status izin-status">
                                            Izin
                                        </span>

                                    @elseif($attendance->status === 'sakit')

                                        <span class="status sakit-status">
                                            Sakit
                                        </span>

                                    @else

                                        <span class="status alpha-status">
                                            {{ ucfirst($attendance->status ?? 'Alpha') }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" style="text-align:center; padding:30px;">

                                    Belum ada data absensi.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- TOP ATTENDANCE -->
            <div class="top-card">

                <div class="card-header">

                    <div>

                        <h3>
                            Kehadiran Terbaik
                        </h3>

                        <p>
                            Siswa dengan jumlah kehadiran tertinggi
                        </p>

                    </div>

                </div>


                @forelse($topStudents as $top)

                    <div class="top-student">

                        <div class="avatar">

                            {{ strtoupper(substr($top->student->nama ?? 'S', 0, 1)) }}

                        </div>


                        <div class="student-info">

                            <strong>
                                {{ $top->student->nama ?? 'Siswa' }}
                            </strong>

                            <small>
                                {{ $top->student->class->nama_kelas ?? '-' }}
                            </small>

                        </div>


                        <strong>

                            {{ $top->total_hadir }}x

                        </strong>

                    </div>

                @empty

                    <div style="padding:20px; text-align:center;">

                        Belum ada data kehadiran.

                    </div>

                @endforelse

            </div>

        </section>


    </main>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | DATA GRAFIK DARI LARAVEL
    |--------------------------------------------------------------------------
    */

    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);


    /*
    |--------------------------------------------------------------------------
    | GRAFIK STATISTIK ABSENSI (BAR CHART)
    |--------------------------------------------------------------------------
    */

    const attendance = document.getElementById('attendanceChart');

    new Chart(attendance, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Hadir',
                    data: chartData,
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                    }
                }
            }
        }
    });


    /*
    |--------------------------------------------------------------------------
    | GRAFIK STATUS KEHADIRAN (DOUGHNUT CHART)
    |--------------------------------------------------------------------------
    */

    // ✅ KODE BARU (YANG SUDAH AMAN):
const status = document.getElementById('statusChart');

new Chart(status, {
    type: 'doughnut',
    data: {
        labels: [
            'Hadir',
            'Izin',
            'Sakit',
            'Alpha'
        ],
        datasets: [
            {
                data: <?php echo json_encode([$hadir, $jumlahIzin, $jumlahSakit, $jumlahAlpha]); ?>,
                borderWidth: 0
            }
        ]
    },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    function filterDate() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        alert('Silakan pilih tanggal awal dan tanggal akhir.');
        return;
    }

    // Panggil URL dengan parameter query
    window.location.href = `/dashboard?start_date=${startDate}&end_date=${endDate}`;
}

</script>
</body>
</html>