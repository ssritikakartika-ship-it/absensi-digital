<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Absensi | Absensi Digital</title>
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
                <a href="{{ route('student.jadwal', ['nis' => $nis]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition text-gray-300">
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
            <span class="font-bold text-gray-800 text-lg">Scan QR Kehadiran</span>
            <span class="text-xs bg-gray-100 px-3 py-1.5 rounded-xl font-medium">NIS: {{ $nis ?? '-' }}</span>
        </header>

        <main class="flex-1 p-6 md:p-8 flex items-center justify-center">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm text-center max-w-md w-full space-y-6">
                <div class="w-20 h-20 bg-teal-50 text-themeSidebar rounded-3xl flex items-center justify-center text-3xl mx-auto border border-teal-100 shadow-inner">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Arahkan Kamera ke QR Code</h2>
                    <p class="text-xs text-gray-400 mt-1">Pastikan kamu berada di area sekolah untuk melakukan presensi.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 text-gray-400 text-xs">
                    [ Area Kamera Scanner QR ]
                </div>
                <a href="{{ route('student.beranda', ['nis' => $nis]) }}" class="block w-full bg-themeSidebar text-white py-3 rounded-2xl text-xs font-bold hover:bg-opacity-90 transition shadow-sm">
                    Kembali ke Beranda
                </a>
            </div>
        </main>
    </div>
</body>
</html>