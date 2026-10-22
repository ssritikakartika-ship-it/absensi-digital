<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token QR | Absensi Digital</title>
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
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
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
                    <!-- Menu Token QR Aktif -->
                    <a href="{{ route('token-qr.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-white text-themeSidebar font-semibold rounded-lg shadow-sm transition">
                        <i class="fa-solid fa-qrcode w-5"></i> Token QR
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-id-card w-5"></i> Data Absensi
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-file-lines w-5"></i> Laporan
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-bell w-5"></i> Notifikasi
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-200 hover:bg-white/10 rounded-lg transition">
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
            <header class="p-6 pb-2 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Manajemen Token QR</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Generate dan kelola token QR absensi harian</p>
                </div>
            </header>

            <main class="p-6 space-y-4">
                <div class="flex justify-end items-center">
                    <button onclick="openModal('tokenModal')" class="bg-themeBlue hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Generate Token QR
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
                                    <th class="pb-3">LOKASI</th>
                                    <th class="pb-3">QR CODE & TOKEN</th>
                                    <th class="pb-3">TANGGAL</th>
                                    <th class="pb-3">JAM</th>
                                    <th class="pb-3">STATUS</th>
                                    <th class="pb-3 text-center w-28">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($tokens as $index => $item)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 font-medium text-gray-500">{{ $tokens->firstItem() + $index }}</td>
                                    <td class="py-3 font-semibold text-gray-800">{{ $item->location->nama_lokasi ?? 'Lokasi Dihapus' }}</td>
                                    
                                    <!-- Kolom Gambar QR dan Teks Token -->
                                    <td class="py-3">
                                        <div id="qrcode-{{ $item->id }}" class="mb-1 bg-white p-1 inline-block border rounded"></div>
                                        <br>
                                        <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded text-[11px] font-mono font-bold tracking-wider">
                                            {{ $item->token }}
                                        </span>
                                    </td>

                                    <td class="py-3 text-xs">{{ $item->tanggal }}</td>
                                    <td class="py-3 text-xs">{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                                    <td class="py-3">
                                        <span class="bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form action="{{ route('token-qr.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus token QR ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 p-1">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400">
                                        Belum ada token QR yang digenerate.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pt-3 border-t">
                        {{ $tokens->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Generate Token -->
    <div id="tokenModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Generate Token QR Baru</h3>
            <form action="{{ route('token-qr.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Lokasi</label>
                        <select name="qr_location_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->nama_lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jam Mulai</label>
                            <input type="time" name="jam_mulai" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jam Selesai</label>
                            <input type="time" name="jam_selesai" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-themeBlue">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal('tokenModal')" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-themeBlue text-white rounded-lg font-medium">Generate</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal & Library QRCodeJS -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach($tokens as $item)
                if(document.getElementById("qrcode-{{ $item->id }}")) {
                    new QRCode(document.getElementById("qrcode-{{ $item->id }}"), {
                        text: "{{ $item->token }}",
                        width: 75,
                        height: 75,
                    });
                }
            @endforeach
        });
    </script>
</body>
</html>