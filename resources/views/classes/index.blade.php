<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Kelas | Absensi Digital</title>

    @vite(['resources/css/absensi.css'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <a href="{{ route('dashboard') }}" class="menu {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-border-all"></i>
            Dashboard
        </a>

        <a href="{{ route('siswa.index') }}" class="menu {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-graduate"></i>
            Data Siswa
        </a>

        <a href="{{ route('kelas.index') }}" class="menu {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <i class="fa-solid fa-school"></i>
            Data Kelas
        </a>

        <a href="{{ route('lokasi-qr.index') }}" class="menu {{ request()->routeIs('lokasi-qr.*') ? 'active' : '' }}">
            <i class="fa-solid fa-location-dot"></i>
            Lokasi QR
        </a>

        <a href="{{ route('token-qr.index') }}" class="menu {{ request()->routeIs('token-qr.*') ? 'active' : '' }}">
            <i class="fa-solid fa-qrcode"></i>
            Token QR
        </a>

        <a href="{{ route('absensi.index') }}" class="menu {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-user"></i>
            Data Absensi
        </a>

        <a href="{{ route('absensi.laporan') }}" class="menu {{ request()->routeIs('absensi.laporan') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines"></i>
            Laporan
        </a>

        <a href="{{ route('notifikasi.index') }}" class="menu {{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
            <i class="fa-solid fa-bell"></i>
            Notifikasi
        </a>

        <a href="{{ route('setting.index') }}" class="menu {{ request()->routeIs('setting.*') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i>
            Setting
        </a>

        <!-- Form Logout dengan SweetAlert -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="button" onclick="confirmLogout()" class="menu logout" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>
        </form>

    </aside>


    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div>
                <h1>Data Kelas</h1>
                <p>Kelola data kelas pada sistem absensi</p>
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


        <!-- HEADER -->
        <div class="page-section">

            <div>
                <h2>Daftar Kelas</h2>
                <p>Data kelas yang terdaftar dalam sistem</p>
            </div>

            <button type="button" class="filter-btn" onclick="tambahKelas()">
                + Tambah Kelas
            </button>

        </div>


        <!-- CARD -->
        <section class="recent-card">

            <div class="card-header">

                <div>
                    <h3>Data Kelas</h3>
                    <p>Daftar seluruh kelas yang tersedia</p>
                </div>

                <div class="small-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="text"
                        id="searchClass"
                        placeholder="Cari kelas..."
                        onkeyup="searchClass()"
                    >
                </div>

            </div>


            <!-- TABLE -->
            <div class="table-wrapper">

                <table id="classTable">

                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA KELAS</th>
                            <th>KODE KELAS</th>
                            <th>JUMLAH SISWA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($classes as $index => $class)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>{{ $class->nama_kelas }}</strong>
                                </td>

                                <td>
                                    <span class="status hadir">
                                        {{ $class->kode_kelas }}
                                    </span>
                                </td>

                                <td>
                                    {{ $class->students()->count() }} siswa
                                </td>

                                <td>
                                    <button
                                        class="action-btn"
                                        onclick="editClass({{ $class->id }})"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <button
                                        class="action-btn delete"
                                        onclick="deleteClass({{ $class->id }})"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" style="text-align:center;padding:30px;">
                                    Belum ada data kelas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<script>

function searchClass() {
    let input = document.getElementById('searchClass').value.toLowerCase();
    let rows = document.querySelectorAll('#classTable tbody tr');

    rows.forEach(function(row) {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}

function tambahKelas() {
    Swal.fire({
        title: 'Tambah Kelas Baru',
        html:
            '<input id="swal-input1" class="swal2-input" placeholder="Nama Kelas (misal: XII RPL 1)">' +
            '<input id="swal-input2" class="swal2-input" placeholder="Kode Kelas (misal: RPL1)">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#235359',
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value
            ]
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: 'Fitur tambah data kelas siap dihubungkan ke backend!',
                confirmColor: '#235359'
            });
        }
    });
}

function editClass(id) {
    Swal.fire({
        icon: 'info',
        title: 'Edit Kelas',
        text: 'Edit data kelas dengan ID ' + id,
        confirmColor: '#235359'
    });
}

function deleteClass(id) {
    Swal.fire({
        title: 'Hapus Kelas?',
        text: "Data kelas beserta relasinya akan terhapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#235359',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: 'Data kelas berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: "Apakah Anda yakin ingin keluar dari sistem?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#235359',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}

</script>

</body>
</html>