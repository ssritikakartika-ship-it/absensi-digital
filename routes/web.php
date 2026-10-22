<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\QrLocationController;
use App\Http\Controllers\QrTokenController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\Student\AttendanceScanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION ---
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// --- FITUR ADMIN (PANEL UTAMA) ---
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Siswa
    Route::get('/siswa', [StudentController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [StudentController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [StudentController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [StudentController::class, 'destroy'])->name('siswa.destroy');

    // Manajemen Kelas
    Route::get('/kelas', [ClassController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [ClassController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{id}', [ClassController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [ClassController::class, 'destroy'])->name('kelas.destroy');

    // Manajemen Lokasi GPS Sekolah
    Route::get('/lokasi-qr', [QrLocationController::class, 'index'])->name('lokasi-qr.index');
    Route::post('/lokasi-qr', [QrLocationController::class, 'store'])->name('lokasi-qr.store');
    Route::put('/lokasi-qr/{id}', [QrLocationController::class, 'update'])->name('lokasi-qr.update');
    Route::delete('/lokasi-qr/{id}', [QrLocationController::class, 'destroy'])->name('lokasi-qr.destroy');

    // Manajemen Token QR
    Route::get('/token-qr', [QrTokenController::class, 'index'])->name('token-qr.index');
    Route::post('/token-qr', [QrTokenController::class, 'store'])->name('token-qr.store');
    Route::delete('/token-qr/{id}', [QrTokenController::class, 'destroy'])->name('token-qr.destroy');

    // Kelola Data Absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    Route::get('/scan-absensi', [AbsensiController::class, 'scanForm'])->name('absensi.scanForm');
    Route::post('/scan-absensi', [AbsensiController::class, 'storeScan'])->name('absensi.storeScan');

    // Laporan Absensi (Sudah Diperbaiki)
    Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('absensi.laporan');

    // Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');

    // Pengaturan System / Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');
});


// --- FITUR SISWA (PORTAL SISWA) ---
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/beranda', [StudentPortalController::class, 'beranda'])->name('beranda');
    Route::get('/scan', [AttendanceScanController::class, 'index'])->name('scan');
    Route::post('/scan/process', [AttendanceScanController::class, 'store'])->name('scan.process');
    Route::get('/profil', [StudentPortalController::class, 'profil'])->name('profil');
    Route::get('/absensi', [StudentPortalController::class, 'absensi'])->name('absensi');
    Route::get('/jadwal', [StudentPortalController::class, 'jadwal'])->name('jadwal');
    Route::get('/riwayat', [StudentPortalController::class, 'riwayat'])->name('riwayat');
});