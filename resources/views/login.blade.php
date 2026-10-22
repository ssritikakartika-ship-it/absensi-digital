<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Absensi Digital</title>

    @vite(['resources/css/login.css'])
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="login-container">

    <!-- BAGIAN KIRI -->
    <div class="login-left">

        <div class="brand">
            <div class="brand-icon">✓</div>
            <span>ABSENSI DIGITAL</span>
        </div>

        <div class="illustration">
            <div class="circle"></div>

            <div class="person">
                👨‍💻
            </div>

            <div class="desk">
                <div class="laptop">💻</div>
            </div>
        </div>

        <div class="welcome">
            <h1>Kelola Absensi<br>Lebih Mudah</h1>

            <p>
                Sistem absensi digital untuk membantu
                mengelola kehadiran siswa dengan cepat
                dan praktis.
            </p>
        </div>

    </div>


    <!-- BAGIAN KANAN -->
    <div class="login-right">

        <div class="login-box">

            <div class="login-logo">
                <div>✓</div>
            </div>

            <h2>Selamat Datang!</h2>

            <p class="subtitle">
                Silakan masuk ke akun administrator
            </p>

            <form method="POST" action="{{ route('login.process') }}">

                @csrf

                <div class="input-group">

                    <label>Email</label>

                    <div class="input-box">
                        <span>✉</span>

                        <input
                            type="email"
                            name="email"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                </div>


                <div class="input-group">

                    <label>Password</label>

                    <div class="input-box">

                        <span>🔒</span>

                        <input
                            type="password"
                            id="passwordInput"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >

                        <span class="eye" id="togglePassword" style="cursor: pointer;">◉</span>

                    </div>

                </div>


                <div class="login-options">

                    <label>
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>

                    <a href="#">
                        Lupa password?
                    </a>

                </div>


                <button type="submit" id="btn-login" class="login-button">
                    Login
                </button>

            </form>


            <div class="divider">
                <span>atau</span>
            </div>


            <p class="footer-text">
                © 2026 Absensi Digital
            </p>

        </div>

    </div>

</div>

<!-- Script untuk SweetAlert & Password Toggle -->
<script>
    // 1. Fitur Toggle Intip Password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    }

    // 2. Alert Salah Password Biasa (Gagal 1x atau 2x)
    @if(session('error_login'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal Login!',
            text: "{{ session('error_login') }}",
            confirmColor: '#235359'
        });
    @endif

    // 3. Alert Lockout 60 Detik (Hitungan Mundur Smooth)
    @if(session('error_lockout'))
        let timerSeconds = parseInt("{{ session('error_lockout') }}");
        const btnLogin = document.getElementById('btn-login');
        
        if (btnLogin) {
            btnLogin.disabled = true;
            btnLogin.style.opacity = "0.5";
            btnLogin.style.cursor = "not-allowed";
        }

        // Buka SweetAlert sekali saja, lalu update teks HTML di dalamnya
        Swal.fire({
            icon: 'warning',
            title: 'Akses Terkunci!',
            html: `Anda sudah 3 kali salah memasukkan password.<br>Silakan tunggu <b id="countdown-timer">${timerSeconds}</b> detik lagi.`,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });

        let timerInterval = setInterval(() => {
            timerSeconds--;
            const timerElement = document.getElementById('countdown-timer');
            if (timerElement) {
                timerElement.innerText = timerSeconds;
            }

            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                if (btnLogin) {
                    btnLogin.disabled = false;
                    btnLogin.style.opacity = "1";
                    btnLogin.style.cursor = "pointer";
                }
                
                Swal.fire({
                    icon: 'info',
                    title: 'Silakan Coba Lagi',
                    text: 'Waktu tunggu selesai. Anda dapat mencoba masuk kembali.',
                    confirmColor: '#235359'
                });
            }
        }, 1000);
    @endif
</script>

</body>
</html>