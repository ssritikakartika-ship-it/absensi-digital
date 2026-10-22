<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi | Absensi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        themeSidebar: '#235359',
                        themeBlue: '#38a1e0',
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
        <aside class="w-60 bg-themeSidebar text-white flex flex-col justify-between p-4 flex-shrink-0 print:hidden">
            <div>
                <div class="px-3 py-2 mb-6">
                    <h2 class="text-2xl font-bold tracking-wide">Absensi</h2>
                </div>

                <div class="text-[11px] font-bold text-gray-300 tracking-wider uppercase px-3 mb-3">MENU</div>

                <nav class="space-y-1 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-user-graduate w-5"></i> Data Siswa
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-building-columns w-5"></i> Data Kelas
                    </a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-location-dot w-5"></i> Lokasi QR
                    </a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-qrcode w-5"></i> Token QR
                    </a>
                    <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-id-card w-5"></i> Data Absensi
                    </a>
                    <!-- Menu Laporan Aktif -->
                    <a href="{{ route('absensi.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 bg-white text-themeSidebar font-semibold rounded-lg shadow-sm transition">
                        <i class="fa-solid fa-file-lines w-5"></i> Laporan
                    </a>
                    <a href="{{ route('notifikasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-bell w-5"></i> Notifikasi
                    </a>
                    <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-gear w-5"></i> Setting
                    </a>
                </nav>
            </div>

            <div class="pt-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition text-sm font-medium text-left">
                        <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="p-6 pb-4 flex justify-between items-center bg-white border-b border-gray-100 print:hidden">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Laporan Absensi Siswa</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Filter dan cetak rekapitulasi kehadiran siswa</p>
                </div>
            </header>

            <main class="p-6">
                <!-- Form Filter & Cetak -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 print:hidden">
                    <form method="GET" action="{{ route('absensi.laporan') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-themeSidebar">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-themeSidebar">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-themeSidebar text-white text-sm font-medium rounded-lg hover:bg-opacity-90 transition">
                                <i class="fa-solid fa-filter mr-1"></i> Filter
                            </button>
                            <button type="button" onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                                <i class="fa-solid fa-print mr-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Judul Cetak (Hanya Muncul Saat Print) -->
                <div class="hidden print:block mb-6 text-center">
                    <h2 class="text-xl font-bold text-gray-900">REKAPITULASI LAPORAN ABSENSI SISWA</h2>
                    @if(request('tanggal_mulai') && request('tanggal_selesai'))
                        <p class="text-sm text-gray-600">Periode: {{ request('tanggal_mulai') }} s/d {{ request('tanggal_selesai') }}</p>
                    @endif
                </div>

                <!-- Tabel Laporan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-none">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-[11px] font-bold text-gray-400 tracking-wider uppercase border-b border-gray-100 print:bg-white print:text-black">
                                    <th class="py-3 px-6">No</th>
                                    <th class="py-3 px-6">Nama Siswa</th>
                                    <th class="py-3 px-6">Kelas</th>
                                    <th class="py-3 px-6">Tanggal</th>
                                    <th class="py-3 px-6">Waktu Masuk</th>
                                    <th class="py-3 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($absensis as $index => $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 text-gray-600">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-800">{{ $item->siswa->nama ?? ($item->siswa->name ?? '-') }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $item->siswa->class->nama_kelas ?? ($item->siswa->kelas->nama_kelas ?? '-') }}</td>
                                    <td class="py-4 px-6 text-gray-600 text-xs">{{ $item->tanggal }}</td>
                                    <td class="py-4 px-6 text-gray-600 text-xs">{{ $item->jam_masuk ?? '-' }} WIB</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-2.5 py-1 rounded-full print:bg-transparent print:p-0">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-400">Tidak ada data laporan untuk periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>