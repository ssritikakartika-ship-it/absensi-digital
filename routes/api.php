<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QrLocationController;
use App\Http\Controllers\QrTokenController;
use App\Http\Controllers\Student\AttendanceScanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes - Sistem Absensi Digital
|--------------------------------------------------------------------------
*/

// 1. Auth API (Untuk Aplikasi Flutter Mobile)
Route::post('/login', [AuthController::class, 'login']);

// 2. Dashboard Admin
Route::get('/dashboard', [DashboardController::class, 'index']);

// 3. Management Master Data
Route::apiResource('classes', ClassController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('qr-locations', QrLocationController::class);

// 4. QR Token Generator (Admin/Pengawas)
Route::post('/qr-token/generate', [QrTokenController::class, 'generateToken']);
Route::get('/qr-token/active', [QrTokenController::class, 'getActiveToken']);

// 5. Fitur Scan Absensi & Protected Routes (Membutuhkan Login / Token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/attendance/scan', [AttendanceScanController::class, 'scan']);
});