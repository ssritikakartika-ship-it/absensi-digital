<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi QR | Absensi Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-teal-main { background-color: #007a78; }
        .text-teal-main { color: #007a78; }
        .hover-teal:hover { background-color: #006361; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex text-gray-800">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-teal-main text-white flex flex-col justify-between min-h-screen p-4 flex-shrink-0">
        <div>
            <!-- Brand / Title -->
            <div class="px-4 py-3 mb-6">
                <h1 class="text-xl font-bold tracking-wide">Absensi Digital</h1>
            </div>

            <!-- Menu Utama -->
            <div class="mb-6">
                <p class="px-4 text-xs font-semibold text-teal-200 tracking-wider uppercase mb-3">Menu Utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="user-check" class="w-5 h-5"></i>
                        <span class="font-medium">Data Siswa</span>
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('kelas.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                        <span class="font-medium">Data Kelas</span>
                    </a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('lokasi-qr.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                        <span>Lokasi QR</span>
                    </a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('token-qr.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="qr-code" class="w-5 h-5"></i>
                        <span class="font-medium">Token QR</span>
                    </a>
                    <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('absensi.index') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                        <span class="font-medium">Data Absensi</span>
                    </a>
                    <a href="{{ route('absensi.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('absensi.laporan') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                    <a href="{{ route('notifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('notifikasi.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="font-medium">Notifikasi</span>
                    </a>
                    <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('setting.*') ? 'bg-teal-800/60 font-semibold text-white shadow-inner' : 'text-teal-100 hover:bg-teal-700/50 transition' }}">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span class="font-medium">Setting</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Tombol Logout dengan Pop-Up -->
        <div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-teal-100 hover:bg-teal-700/50 transition text-left">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- HEADER / NAVBAR TOP -->
        <header class="flex items-center justify-between px-8 py-5 bg-transparent">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Lokasi QR</h1>
                <p class="text-sm text-gray-500">Kelola titik koordinat & radius lokasi absensi siswa</p>
            </div>

            <!-- Profile User -->
            <div class="flex items-center gap-4">
                <a href="{{ route('notifikasi.index') }}" class="p-2 bg-amber-50 rounded-full text-amber-500 cursor-pointer block">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </a>
                <div class="flex items-center gap-3 pl-2">
                    <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-main font-bold flex items-center justify-center">
                        A
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 leading-tight">Admin</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="px-8 pb-8 space-y-6">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Tambah Lokasi QR -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Lokasi Absensi Baru</h2>
                
                <form action="{{ route('lokasi-qr.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" placeholder="Misal: Kampus Utama / Gedung A" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kode Lokasi</label>
                        <input type="text" name="kode_lokasi" placeholder="Misal: LOK-01" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Latitude</label>
                        <input type="text" name="latitude" placeholder="-6.914744" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Longitude</label>
                        <input type="text" name="longitude" placeholder="107.609810" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-teal-500" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Radius Toleransi (Meter)</label>
                        <input type="number" name="radius" placeholder="100" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-teal-500" required>
                    </div>
                    <div class="md:col-span-2 flex justify-end mt-2">
                        <button type="submit" class="bg-teal-main hover-teal text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Simpan Lokasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Lokasi -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Lokasi QR</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="p-3 rounded-l-xl">NO</th>
                                <th class="p-3">NAMA LOKASI</th>
                                <th class="p-3">KODE</th>
                                <th class="p-3">KOORDINAT (LAT, LONG)</th>
                                <th class="p-3">RADIUS</th>
                                <th class="p-3 rounded-r-xl text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($locations as $index => $loc)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3 font-medium text-gray-500">{{ $index + 1 }}</td>
                                    <td class="p-3 font-semibold text-gray-800">{{ $loc->nama_lokasi }}</td>
                                    <td class="p-3 text-gray-600">{{ $loc->kode_lokasi }}</td>
                                    <td class="p-3 text-gray-600 font-mono text-xs">{{ $loc->latitude }}, {{ $loc->longitude }}</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 bg-teal-50 text-teal-main font-semibold text-xs rounded-full">
                                            {{ $loc->radius }} Meter
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 transition">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400">
                                        Belum ada data lokasi QR yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        lucide.createIcons();

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar dari sistem?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#007a78',
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