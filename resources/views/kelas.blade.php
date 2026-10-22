<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas | Absensi Digital</title>
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
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-border-all w-5"></i> Dashboard</a>
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-user-graduate w-5"></i> Data Siswa</a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-white text-themeSidebar font-semibold rounded-lg shadow-sm transition"><i class="fa-solid fa-building-columns w-5"></i> Data Kelas</a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-location-dot w-5"></i> Lokasi QR</a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-qrcode w-5"></i> Token QR</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-id-card w-5"></i> Data Absensi</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-file-lines w-5"></i> Laporan</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-bell w-5"></i> Notifikasi</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-gear w-5"></i> Setting</a>
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="p-6 pb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Kelas</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola daftar kelas dan rombel siswa</p>
                </div>
            </header>

            <main class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <form action="{{ route('kelas.index') }}" method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Kelas..." class="bg-white border-none shadow-sm rounded-lg px-3 py-2 text-sm focus:outline-none w-64">
                        <button type="submit" class="bg-themeBlue text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                    </form>
                    <button onclick="openModal('addModal')" class="bg-themeBlue hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Kelas
                    </button>
                </div>

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
                                    <th class="pb-3">NAMA KELAS</th>
                                    <th class="pb-3">JUMLAH SISWA</th>
                                    <th class="pb-3 text-center w-28">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($classes as $index => $class)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 font-medium text-gray-500">{{ $classes->firstItem() + $index }}</td>
                                    <td class="py-3 font-semibold text-gray-800">{{ $class->nama_kelas }}</td>
                                    <td class="py-3">
                                        <span class="bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $class->students_count }} Siswa
                                        </span>
                                    </td>
                                    <td class="py-3 text-center space-x-2">
                                        <button onclick="editModal('{{ $class->id }}', '{{ $class->nama_kelas }}')" class="text-amber-500 hover:text-amber-600 p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="{{ route('kelas.destroy', $class->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kelas ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 p-1"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-8 text-center text-gray-400">Belum ada data kelas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 pt-3 border-t">{{ $classes->links() }}</div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Kelas Baru</h3>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Kelas</label>
                        <input type="text" name="nama_kelas" placeholder="Contoh: XII RPL 1" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-themeBlue text-white rounded-lg font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Data Kelas</h3>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="edit_nama_kelas" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-amber-500 text-white rounded-lg font-medium">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }
        function editModal(id, namaKelas) {
            document.getElementById('editForm').action = '/kelas/' + id;
            document.getElementById('edit_nama_kelas').value = namaKelas;
            openModal('editModal');
        }
    </script>
</body>
</html>