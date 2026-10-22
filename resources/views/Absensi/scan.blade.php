<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Absensi QR | Absensi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Library QR Scanner (html5-qrcode) -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
<body class="bg-themeBg font-sans text-gray-700 antialiased min-h-screen flex flex-col justify-between">

    <!-- Navbar / Header Siswa -->
    <header class="bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-themeSidebar text-white rounded-lg flex items-center justify-center font-bold">
                <i class="fa-solid fa-qrcode text-sm"></i>
            </div>
            <span class="font-bold text-gray-800">Absensi Siswa</span>
        </div>
        <nav class="flex items-center gap-4 text-sm font-semibold">
            <!-- Diperbaiki: Menggunakan route Laravel -->
            <a href="{{ route('student.beranda') }}" class="text-gray-600 hover:text-themeSidebar transition">Beranda</a>
            <a href="{{ route('student.scan') }}" class="text-themeSidebar border-b-2 border-themeSidebar pb-0.5">Scan QR</a>
            <a href="{{ route('student.profil') }}" class="text-gray-600 hover:text-themeSidebar transition">Profil</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold text-gray-800">Scan QR Code Kehadiran</h1>
                <p class="text-xs text-gray-500 mt-0.5">Arahkan kamera ke QR Code lokasi atau masukkan data di bawah</p>
            </div>

            @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-4 flex items-start gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm mb-4 flex items-start gap-2 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-red-600 mt-0.5"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <!-- Kotak Kamera Scanner -->
            <div id="reader" class="w-full rounded-xl overflow-hidden mb-4 border border-gray-200"></div>

            <form action="{{ route('absensi.storeScan') }}" method="POST" class="space-y-3" id="scanForm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" required placeholder="Masukkan NIS kamu" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-themeSidebar">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Token QR</label>
                    <input type="text" id="tokenInput" name="token" required placeholder="Hasil scan atau ketik token" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-themeSidebar">
                </div>

                <button type="submit" class="w-full bg-themeSidebar text-white py-3 rounded-xl text-sm font-semibold hover:bg-opacity-90 transition shadow-sm">
                    Kirim Absensi
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-xs text-gray-400">
        &copy; 2026 Absensi Digital Sekolah
    </footer>

    <!-- Script Kamera QR Scanner -->
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Masukkan hasil scan otomatis ke input token
            document.getElementById('tokenInput').value = decodedText;
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }, false);
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>