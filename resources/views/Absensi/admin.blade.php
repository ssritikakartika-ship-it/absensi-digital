<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi | Absensi Digital</title>
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
        <aside class="w-60 bg-themeSidebar text-white flex flex-col justify-between p-4 flex-shrink-0">
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
                    <!-- Menu Data Absensi Aktif -->
                    <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-white text-themeSidebar font-semibold rounded-lg shadow-sm transition">
                        <i class="fa-solid fa-id-card w-5"></i> Data Absensi
                    </a>
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
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
            <header class="p-6 pb-4 flex justify-between items-center bg-white border-b border-gray-100">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Manajemen Data Absensi</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Rekapitulasi seluruh data kehadiran siswa secara lengkap</p>
                </div>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tabel Data Absensi Keseluruhan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-base font-bold text-gray-800">Daftar Kehadiran Siswa</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-[11px] font-bold text-gray-400 tracking-wider uppercase border-b border-gray-100">
                                    <th class="py-3 px-6">No</th>
                                    <th class="py-3 px-6">Nama Siswa</th>
                                    <th class="py-3 px-6">Kelas</th>
                                    <th class="py-3 px-6">Tanggal</th>
                                    <th class="py-3 px-6">Waktu Masuk</th>
                                    <th class="py-3 px-6">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($absensis as $index => $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 text-gray-600">{{ $absensis->firstItem() + $index }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-800">{{ $item->siswa->nama ?? ($item->siswa->name ?? '-') }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td class="py-4 px-6 text-gray-600 text-xs">{{ $item->tanggal }}</td>
                                    <td class="py-4 px-6 text-gray-600 text-xs">{{ $item->jam_masuk ?? '-' }} WIB</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <form action="{{ route('absensi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium px-2 py-1 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-400">Belum ada data absensi.</td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        {{ $absensis->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>