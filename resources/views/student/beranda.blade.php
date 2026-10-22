<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Siswa | Absensi Digital</title>
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
            <!-- LOGO -->
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

            <!-- NAVIGASI MENU -->
            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('student.beranda') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.beranda') ? 'bg-white/10 text-white shadow-inner' : 'hover:bg-white/5 transition text-gray-300' }}">
                    <i class="fa-solid fa-house w-5"></i> Beranda
                </a>
                <a href="{{ route('student.scan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.scan') ? 'bg-white/10 text-white shadow-inner' : 'hover:bg-white/5 transition text-gray-300' }}">
                    <i class="fa-solid fa-qrcode w-5"></i> Scan QR
                </a>
                <a href="{{ route('student.absensi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.absensi') ? 'bg-white/10 text-white shadow-inner' : 'hover:bg-white/5 transition text-gray-300' }}">
                    <i class="fa-solid fa-clipboard-user w-5"></i> Data Absensi
                </a>
                <a href="{{ route('student.profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.profil') ? 'bg-white/10 text-white shadow-inner' : 'hover:bg-white/5 transition text-gray-300' }}">
                    <i class="fa-solid fa-user w-5"></i> Profil Saya
                </a>
            </nav>
        </div>

        <!-- LOGOUT FORM (DI PALING BAWAH + MERAH + GARIS ATAS) -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="pt-6 border-t border-white/10">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 transition text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
            </button>
        </form>
    </aside>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- TOPBAR -->
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex justify-between items-center shadow-sm">
            <div>
                <h1 class="font-bold text-gray-800 text-lg">Beranda Siswa</h1>
                <p class="text-xs text-gray-500">Selamat datang kembali di Portal Absensi Digital</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-800">{{ auth()->user()->name ?? 'Siswa' }}</p>
                    <p class="text-[11px] text-gray-500">{{ auth()->user()->email ?? '-' }}</p>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 p-6 md:p-8 space-y-6">
            <!-- CARDS INFO SISWA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Total Hadir</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $totalHadir ?? 0 }}</h2>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Izin / Sakit</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $totalIzinSakit ?? 0 }}</h2>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Alpha</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $totalAlpha ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT ABSENSI TERAKHIR -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Riwayat Absensi Terakhir</h3>
                    <p class="text-xs text-gray-400">Daftar absensi harian kamu</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Waktu Check-In</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                        @forelse ($riwayatAbsensi ?? [] as $absensi)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                                <td class="py-3 px-4 font-medium">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">{{ $absensi->waktu ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    @if($absensi->status === 'hadir')
                                        <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-lg text-[10px] font-bold">Hadir</span>
                                    @elseif($absensi->status === 'izin')
                                        <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-lg text-[10px] font-bold">Izin</span>
                                    @elseif($absensi->status === 'sakit')
                                        <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-lg text-[10px] font-bold">Sakit</span>
                                    @else
                                        <span class="bg-rose-100 text-rose-700 px-2.5 py-1 rounded-lg text-[10px] font-bold">{{ ucfirst($absensi->status ?? 'Alpha') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-400">Belum ada riwayat absensi.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        @if(session('success_login'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login!',
                text: "{{ session('success_login') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

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