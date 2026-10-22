<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan | Absensi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        themeSidebar: '#235359',
                        themeBg: '#f3f4f6'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-themeBg font-sans text-gray-700 antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-60 bg-themeSidebar text-white flex flex-col justify-between p-4 flex-shrink-0">
            <div>
                <div class="px-3 py-2 mb-6">
                    <h2 class="text-2xl font-bold tracking-wide">Absensi</h2>
                </div>
                <div class="text-[11px] font-bold text-gray-300 tracking-wider uppercase px-3 mb-3">MENU</div>
                <nav class="space-y-1 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('siswa.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-user-graduate w-5"></i> Data Siswa
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('kelas.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-building-columns w-5"></i> Data Kelas
                    </a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('lokasi-qr.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-location-dot w-5"></i> Lokasi QR
                    </a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('token-qr.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-qrcode w-5"></i> Token QR
                    </a>
                    <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('absensi.index') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-id-card w-5"></i> Data Absensi
                    </a>
                    <a href="{{ route('absensi.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('absensi.laporan') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-file-lines w-5"></i> Laporan
                    </a>
                    <a href="{{ route('notifikasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('notifikasi.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-bell w-5"></i> Notifikasi
                    </a>
                    <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('setting.*') ? 'bg-white text-themeSidebar font-semibold' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-gear w-5"></i> Setting
                    </a>
                </nav>
            </div>
            
            <!-- Logout dengan Pop-Up SweetAlert -->
            <div class="pt-4 border-t border-white/10">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition text-sm font-medium text-left">
                        <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="p-6 pb-4 bg-white border-b border-gray-100">
                <h1 class="text-xl font-bold text-gray-800">Pengaturan Aplikasi</h1>
                <p class="text-xs text-gray-500 mt-0.5">Atur jam operasional dan identitas instansi</p>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
                    <form action="{{ route('setting.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Instansi / Sekolah</label>
                            <input type="text" name="nama_sekolah" value="Absensi Digital School" class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-themeSidebar">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Jam Masuk</label>
                                <input type="time" name="jam_masuk" value="07:00" class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-themeSidebar">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Jam Pulang</label>
                                <input type="time" name="jam_pulang" value="15:00" class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-themeSidebar">
                            </div>
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-themeSidebar text-white text-sm font-medium rounded-xl hover:bg-opacity-90 transition">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>

<script>
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