<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Diri Siswa | Absensi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { themeSidebar: '#235359', themeBg: '#f3f4f6' } } } }
    </script>
</head>
<body class="bg-themeBg font-sans text-gray-700 antialiased min-h-screen flex">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-themeSidebar text-gray-300 flex flex-col justify-between hidden md:flex p-6 shadow-sm min-h-screen">
        <div>
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-white/10 text-white rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="font-bold text-white text-sm">Portal Siswa</h1>
                    <p class="text-[11px] text-gray-300">Absensi Digital</p>
                </div>
            </div>
            
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">MENU SISWA</p>

            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('student.beranda') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-house w-5"></i> Beranda
                </a>
                <a href="{{ route('student.scan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-qrcode w-5"></i> Scan QR
                </a>
                <a href="{{ route('student.absensi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-clipboard-user w-5"></i> Data Absensi
                </a>
                <a href="{{ route('student.profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white shadow-inner">
                    <i class="fa-solid fa-user w-5"></i> Profil Saya
                </a>
            </nav>
        </div>

        <!-- LOGOUT FORM -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="pt-6 border-t border-white/10">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 transition text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
            </button>
        </form>
    </aside>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex justify-between items-center shadow-sm">
            <div>
                <h1 class="font-bold text-gray-800 text-lg">Data Diri Siswa</h1>
                <p class="text-xs text-gray-500">Informasi profil akun siswa</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-800">{{ auth()->user()->name ?? 'Siswa' }}</p>
                    <p class="text-[11px] text-gray-500">{{ auth()->user()->email ?? '-' }}</p>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 md:p-8 flex items-center justify-center">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm max-w-lg w-full space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-themeSidebar text-white font-bold text-xl rounded-2xl flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ auth()->user()->name ?? 'Nama Siswa' }}</h2>
                        <p class="text-xs text-gray-500">Siswa Aktif • Absensi Digital SMKN 1 Maja</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[11px] font-bold text-gray-400 uppercase">NOMOR INDUK SISWA (NIS)</p>
                        <p class="text-sm font-bold text-gray-800 mt-1">{{ $student->nis ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[11px] font-bold text-gray-400 uppercase">KELAS</p>
                        <p class="text-sm font-bold text-gray-800 mt-1">{{ $student->class->nama_kelas ?? ($student->kelas->nama_kelas ?? '-') }}</p>
                    </div>
                </div>

                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-800">STATUS KEAKTIFAN</p>
                        <p class="text-[11px] text-emerald-600">Akun terverifikasi sistem sekolah</p>
                    </div>
                    <span class="bg-emerald-500 text-white text-[10px] font-bold px-3 py-1 rounded-full">Aktif</span>
                </div>

                <a href="{{ route('student.beranda') }}" class="block text-center bg-themeSidebar text-white py-3 rounded-2xl text-xs font-bold hover:bg-opacity-90 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </main>
    </div>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
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