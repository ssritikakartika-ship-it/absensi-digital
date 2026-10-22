<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa | Absensi Digital</title>
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
                    <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-white text-themeSidebar font-semibold rounded-lg shadow-sm transition"><i class="fa-solid fa-user-graduate w-5"></i> Data Siswa</a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-building-columns w-5"></i> Data Kelas</a>
                    <a href="{{ route('lokasi-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-location-dot w-5"></i> Lokasi QR</a>
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-qrcode w-5"></i> Token QR</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-id-card w-5"></i> Data Absensi</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-file-lines w-5"></i> Laporan</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-bell w-5"></i> Notifikasi</a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition"><i class="fa-solid fa-gear w-5"></i> Setting</a>
                </nav>
            </div>
            <div class="pt-4 border-t border-white/10">
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition text-sm font-medium"><i class="fa-solid fa-right-from-bracket w-5"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="p-6 pb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola daftar seluruh siswa</p>
                </div>
            </header>

            <main class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <form action="{{ route('siswa.index') }}" method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Siswa/NIS..." class="bg-white border-none shadow-sm rounded-lg px-3 py-2 text-sm focus:outline-none w-64">
                        <button type="submit" class="bg-themeBlue text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                    </form>
                    <button onclick="openModal('addModal')" class="bg-themeBlue hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Siswa
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
                                    <th class="pb-3">NIS</th>
                                    <th class="pb-3">NAMA SISWA</th>
                                    <th class="pb-3">KELAS</th>
                                    <th class="pb-3 text-center w-28">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($students as $index => $student)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 font-medium text-gray-500">{{ $students->firstItem() + $index }}</td>
                                    <td class="py-3 font-mono text-xs">{{ $student->nis }}</td>
                                    <td class="py-3 font-semibold text-gray-800">{{ $student->nama }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('kelas.index') }}" class="bg-blue-50 text-themeBlue px-2.5 py-1 rounded-full text-xs font-semibold hover:bg-blue-100 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-building-columns text-[10px]"></i> {{ $student->class->nama_kelas ?? '-' }}
                                        </a>
                                    </td>
                                    <td class="py-3 text-center space-x-2">
                                        <button onclick="editModal('{{ $student->id }}', '{{ $student->nis }}', '{{ $student->nama }}', '{{ $student->class_id }}')" class="text-amber-500 hover:text-amber-600 p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="{{ route('siswa.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus siswa ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 p-1"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada data siswa.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 pt-3 border-t">{{ $students->links() }}</div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Siswa Baru</h3>
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1">NIS</label><input type="text" name="nis" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue"></div>
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label><input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue"></div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kelas</label>
                        <select name="class_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
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
            <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Data Siswa</h3>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1">NIS</label><input type="text" name="nis" id="edit_nis" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue"></div>
                    <div><label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label><input type="text" name="name" id="edit_name" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue"></div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kelas</label>
                        <select name="class_id" id="edit_class_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
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
        function editModal(id, nis, name, classId) {
            document.getElementById('editForm').action = '/siswa/' + id;
            document.getElementById('edit_nis').value = nis;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_class_id').value = classId;
            openModal('editModal');
        }
    </script>
</body>
</html>