<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Token QR | Absensi Digital</title>

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
                <h1>Token QR</h1>
                <p>Kelola token QR untuk proses absensi</p>
            </div>

            <div class="top-right">

                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="text"
                        id="searchToken"
                        placeholder="Cari token..."
                        onkeyup="searchToken()"
                    >
                </div>

                <div class="notification">
                    <i class="fa-solid fa-bell"></i>
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


        <!-- PAGE -->
        <div class="page-section">

            <div class="page-title">

                <div>
                    <h2>Daftar Token QR</h2>

                    <p>
                        Daftar token QR yang digunakan untuk absensi siswa.
                    </p>
                </div>

                <button
                    type="button"
                    class="filter-btn"
                    onclick="openModal()"
                >
                    + Buat Token QR
                </button>

            </div>


            <!-- SUCCESS MESSAGE -->
            @if(session('success'))

                <div class="alert-success">
                    {{ session('success') }}
                </div>

            @endif


            <!-- ERROR MESSAGE -->
            @if($errors->any())

                <div class="alert-error">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- TABLE -->
            <section class="recent-card">

                <div class="card-header">

                    <div>

                        <h3>
                            Data Token QR
                        </h3>

                        <span>
                            Token yang tersedia
                        </span>

                    </div>


                    <div class="small-search">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="text"
                            id="tableSearch"
                            placeholder="Cari..."
                            onkeyup="searchToken()"
                        >

                    </div>

                </div>


                <div class="table-wrapper">

                    <table id="tokenTable">

                        <thead>

                            <tr>

                                <th>NO</th>
                                <th>LOKASI</th>
                                <th>TANGGAL</th>
                                <th>WAKTU</th>
                                <th>TOKEN</th>
                                <th>STATUS</th>
                                <th>AKSI</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($tokens as $index => $token)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $token->qrLocation->nama_lokasi ?? '-' }}
                                        </strong>

                                    </td>


                                    <td>

                                        {{ \Carbon\Carbon::parse($token->tanggal)->format('d-m-Y') }}

                                    </td>


                                    <td>

                                        {{ $token->waktu_mulai }}
                                        -
                                        {{ $token->waktu_berakhir }}

                                    </td>


                                    <td>

                                        <span class="status hadir">
                                            {{ substr($token->token, 0, 12) }}...
                                        </span>

                                    </td>


                                    <td>

                                        @if($token->status)

                                            <span class="status hadir">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="status alpha">
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <button
                                            type="button"
                                            class="action-btn"
                                            onclick="viewToken('{{ $token->token }}')"
                                        >
                                            Lihat
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        style="text-align:center;padding:30px;"
                                    >
                                        Belum ada token QR.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

        </div>

    </main>

</div>


<!-- MODAL BUAT TOKEN QR -->
<div
    id="tokenModal"
    class="modal"
>

    <div class="modal-content">

        <!-- MODAL HEADER -->
        <div class="modal-header">

            <div>
                <h2>Buat Token QR</h2>
                <p>Buat token QR baru untuk absensi.</p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeModal()"
            >
                ×
            </button>

        </div>

        <!-- FORM -->
        <form
            action="{{ route('token-qr.store') }}"
            method="POST"
        >
            @csrf

            <!-- LOKASI -->
            <div class="form-group">
                <label>Lokasi QR</label>
                <select name="qr_location_id" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">
                            {{ $location->nama_lokasi }} ({{ $location->kode_lokasi }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TANGGAL -->
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" required>
            </div>

            <!-- WAKTU -->
            <div class="form-row">
                <div class="form-group">
                    <label>Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" required>
                </div>

                <div class="form-group">
                    <label>Waktu Berakhir</label>
                    <input type="time" name="waktu_berakhir" required>
                </div>
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="modal-actions">
                <button
                    type="button"
                    class="btn-cancel"
                    onclick="closeModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-submit"
                >
                    Buat Token
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function openModal() {
    document.getElementById('tokenModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('tokenModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('tokenModal');
    if (event.target === modal) {
        closeModal();
    }
};

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