<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lokasi QR | Absensi Digital</title>

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
                <h1>Lokasi QR</h1>
                <p>Kelola lokasi yang digunakan untuk absensi QR</p>
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


        <!-- HEADER PAGE -->
        <div class="page-section">

            <div>
                <h2>Daftar Lokasi</h2>
                <p>Data lokasi yang terdaftar dalam sistem</p>
            </div>

            <button
                type="button"
                class="filter-btn"
                onclick="bukaFormTambah()"
            >
                + Tambah Lokasi
            </button>

        </div>


        <!-- CARD TABLE -->
        <section class="recent-card">

            <div class="card-header">

                <div>
                    <h3>Data Lokasi QR</h3>
                    <p>Daftar seluruh lokasi yang tersedia</p>
                </div>

                <div class="small-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="text"
                        id="searchLocation"
                        placeholder="Cari lokasi..."
                        onkeyup="searchLocation()"
                    >
                </div>

            </div>


            <!-- TABLE -->
            <div class="table-wrapper">

                <table id="locationTable">

                    <thead>

                        <tr>
                            <th>NO</th>
                            <th>NAMA LOKASI</th>
                            <th>KODE LOKASI</th>
                            <th>LATITUDE</th>
                            <th>LONGITUDE</th>
                            <th>RADIUS</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($locations as $index => $location)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>{{ $location->nama_lokasi }}</strong>
                                </td>

                                <td>
                                    <span class="status hadir">
                                        {{ $location->kode_lokasi }}
                                    </span>
                                </td>

                                <td>{{ $location->latitude }}</td>

                                <td>{{ $location->longitude }}</td>

                                <td>{{ $location->radius }} m</td>

                                <td>
                                    @if($location->status)
                                        <span class="status hadir">Aktif</span>
                                    @else
                                        <span class="status alpha">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td>
                                    <button
                                        class="action-btn"
                                        onclick="editLocation({{ $location->id }})"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <button
                                        class="action-btn delete"
                                        onclick="deleteLocation({{ $location->id }})"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" style="text-align:center;padding:30px;">
                                    Belum ada data lokasi QR.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<!-- MODAL TAMBAH LOKASI -->
<div
    id="modalTambah"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.45);
        align-items:center;
        justify-content:center;
        z-index:9999;
    "
>

    <div
        style="
            width:500px;
            max-width:90%;
            background:white;
            border-radius:12px;
            padding:25px;
            box-shadow:0 10px 40px rgba(0,0,0,.2);
        "
    >

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:20px;
            "
        >
            <h3 style="margin:0;">Tambah Lokasi QR</h3>

            <button
                type="button"
                onclick="tutupFormTambah()"
                style="
                    border:none;
                    background:none;
                    font-size:25px;
                    cursor:pointer;
                "
            >
                ×
            </button>
        </div>


        <form action="{{ route('lokasi-qr.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:15px;">
                <label><strong>Nama Lokasi</strong></label>
                <input
                    type="text"
                    name="nama_lokasi"
                    placeholder="Contoh: Sekolah"
                    required
                    style="
                        width:100%;
                        box-sizing:border-box;
                        padding:10px;
                        margin-top:6px;
                        border:1px solid #ddd;
                        border-radius:6px;
                    "
                >
            </div>

            <div style="margin-bottom:15px;">
                <label><strong>Kode Lokasi</strong></label>
                <input
                    type="text"
                    name="kode_lokasi"
                    placeholder="Contoh: SEKOLAH01"
                    required
                    style="
                        width:100%;
                        box-sizing:border-box;
                        padding:10px;
                        margin-top:6px;
                        border:1px solid #ddd;
                        border-radius:6px;
                    "
                >
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label><strong>Latitude</strong></label>
                    <input
                        type="text"
                        name="latitude"
                        placeholder="-6.836900"
                        required
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:10px;
                            margin-top:6px;
                            border:1px solid #ddd;
                            border-radius:6px;
                        "
                    >
                </div>

                <div>
                    <label><strong>Longitude</strong></label>
                    <input
                        type="text"
                        name="longitude"
                        placeholder="108.227100"
                        required
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:10px;
                            margin-top:6px;
                            border:1px solid #ddd;
                            border-radius:6px;
                        "
                    >
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-top:15px;">
                <div>
                    <label><strong>Radius (meter)</strong></label>
                    <input
                        type="number"
                        name="radius"
                        placeholder="100"
                        min="1"
                        required
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:10px;
                            margin-top:6px;
                            border:1px solid #ddd;
                            border-radius:6px;
                        "
                    >
                </div>

                <div>
                    <label><strong>Status</strong></label>
                    <select
                        name="status"
                        required
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:10px;
                            margin-top:6px;
                            border:1px solid #ddd;
                            border-radius:6px;
                        "
                    >
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; justify-flex-end; gap:10px; margin-top:25px;">
                <button
                    type="button"
                    onclick="tutupFormTambah()"
                    style="
                        border:none;
                        padding:10px 18px;
                        border-radius:6px;
                        cursor:pointer;
                        background:#eee;
                    "
                >
                    Batal
                </button>

                <button
                    type="submit"
                    style="
                        border:none;
                        padding:10px 18px;
                        border-radius:6px;
                        cursor:pointer;
                        background:#235359;
                        color:white;
                    "
                >
                    Simpan Lokasi
                </button>
            </div>

        </form>

    </div>

</div>


<script>
function bukaFormTambah() {
    document.getElementById('modalTambah').style.display = 'flex';
}

function tutupFormTambah() {
    document.getElementById('modalTambah').style.display = 'none';
}

function searchLocation() {
    let input = document.getElementById('searchLocation').value.toLowerCase();
    let rows = document.querySelectorAll('#locationTable tbody tr');

    rows.forEach(function(row) {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}

function editLocation(id) {
    Swal.fire({
        icon: 'info',
        title: 'Edit Lokasi',
        text: 'Fitur edit lokasi ID ' + id + ' siap disesuaikan.',
        confirmColor: '#235359'
    });
}

function deleteLocation(id) {
    Swal.fire({
        title: 'Hapus Lokasi?',
        text: "Data lokasi yang dihapus tidak dapat dikembalikan!",
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
                title: 'Berhasil',
                text: 'Lokasi berhasil dihapus.',
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