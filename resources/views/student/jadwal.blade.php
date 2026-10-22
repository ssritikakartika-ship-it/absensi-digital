<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran | Absensi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { themeSidebar: '#235359', themeBg: '#f3f4f6' } } } }
    </script>
</head>
<body class="bg-themeBg font-sans text-gray-700 antialiased min-h-screen flex">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-themeSidebar text-gray-300 flex flex-col justify-between hidden md:flex p-6 shadow-sm">
        <div>
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-white/10 text-white rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="font-bold text-white text-sm">Absensi Digital</h1>
                    <p class="text-[11px] text-gray-300">SMKN 1 Maja</p>
                </div>
            </div>
            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('student.beranda', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-house w-5"></i> Beranda
                </a>
                <a href="{{ route('student.absensi', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-clipboard-user w-5"></i> Absensi
                </a>
                <a href="{{ route('student.jadwal', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white shadow-inner">
                    <i class="fa-solid fa-calendar-days w-5"></i> Jadwal
                </a>
                <a href="{{ route('student.profil', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-user w-5"></i> Data Diri
                </a>
                <a href="{{ route('student.riwayat', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
                    <i class="fa-solid fa-clock-rotate-left w-5"></i> Riwayat Absensi
                </a>
            </nav>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex justify-between items-center shadow-sm">
            <span class="font-bold text-gray-800 text-lg">Jadwal Pelajaran</span>
            <span class="text-xs bg-gray-100 px-3 py-1.5 rounded-xl font-medium">Kelas: {{ $student->kelas->nama_kelas ?? 'XII RPL 3' }}</span>
        </header>

        <main class="flex-1 p-6 md:p-8">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm max-w-3xl mx-auto">
                <h3 class="font-bold text-sm text-gray-800 mb-4">Daftar Mata Pelajaran Hari Ini</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div>
                            <span class="font-bold text-gray-800 block">Pemrograman Web</span>
                            <span class="text-xs text-gray-400">07:00 - 08:40 • Ruang R.3</span>
                        </div>
                        <span class="text-xs bg-teal-100 text-teal-800 px-3 py-1 rounded-xl font-bold">Jam ke-1</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div>
                            <span class="font-bold text-gray-800 block">Basis Data</span>
                            <span class="text-xs text-gray-400">09:00 - 10:40 • Ruang R.3</span>
                        </div>
                        <span class="text-xs bg-teal-100 text-teal-800 px-3 py-1 rounded-xl font-bold">Jam ke-2</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>