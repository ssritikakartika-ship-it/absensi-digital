<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi | Absensi Digital</title>
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
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('siswa.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-user-graduate w-5"></i> Data Siswa
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('kelas.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-building-columns w-5"></i> Data Kelas
                    </a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('lokasi-qr.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-location-dot w-5"></i> Lokasi QR
                    </a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('token-qr.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-qrcode w-5"></i> Token QR
                    </a>
                    <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('absensi.index') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-id-card w-5"></i> Data Absensi
                    </a>
                    <a href="{{ route('absensi.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('absensi.laporan') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-file-lines w-5"></i> Laporan
                    </a>
                    <a href="{{ route('notifikasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('notifikasi.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-bell w-5"></i> Notifikasi
                    </a>
                    <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('setting.*') ? 'bg-white text-themeSidebar font-semibold shadow-sm' : 'text-gray-200 hover:bg-white/10' }} rounded-lg transition">
                        <i class="fa-solid fa-gear w-5"></i> Setting
                    </a>
                </nav>
            </div>

            <!-- Logout dengan SweetAlert -->
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
            <header class="p-6 pb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Absensi Siswa</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Rekapitulasi kehadiran siswa yang melakukan scan QR</p>
                </div>
            </header>

            <main class="p-6 space-y-4">
                @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-2.5 rounded-xl text-sm flex items-center justify-between shadow-sm">
                    <span><i class="fa-solid fa-circle-check me-2 text-emerald-600"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
                </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="text-gray-400 font-semibold text-xs border-b pb-2">
                                <tr>
                                    <th class="pb-3 w-12">NO</th>
                                    <th class="pb-3">NAMA SISWA</th>
                                    <th class="pb-3">KELAS</th>
                                    <th class="pb-3">LOKASI / TOKEN</th>
                                    <th class="pb-3">TANGGAL</th>
                                    <th class="pb-3">JAM MASUK</th>
                                    <th class="pb-3">STATUS</th>
                                    <th class="pb-3 text-center w-28">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($absensis as $index => $item)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 font-medium text-gray-500">{{ $absensis->firstItem() + $index }}</td>
                                    <td class="py-3 font-semibold text-gray-800">{{ $item->siswa->nama ?? 'Siswa Dihapus' }}</td>
                                    <td class="py-3 text-xs">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td class="py-3 text-xs">
                                        <span class="font-medium text-gray-700">{{ $item->qrToken->location->nama_lokasi ?? '-' }}</span><br>
                                        <span class="text-[10px] text-gray-400 font-mono">{{ $item->qrToken->token ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 text-xs">{{ $item->tanggal }}</td>
                                    <td class="py-3 text-xs font-semibold text-indigo-600">{{ $item->jam_masuk }}</td>
                                    <td class="py-3">
                                        <span class="bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('absensi.destroy', $item->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('{{ $item->id }}')" class="text-red-500 hover:text-red-600 p-1">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
<tr>
    <td colspan="8" class="py-8 text-center text-gray-400">
        Belum ada data kehadiran siswa yang tercatat.
    </td>
</tr>
@endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pt-3 border-t">
                        {{ $absensis->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Absensi?',
            text: "Data absensi yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#235359',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
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