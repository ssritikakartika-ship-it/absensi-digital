<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QrLocation;
use App\Models\QrToken;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceScanController extends Controller
{
    /**
     * Menampilkan halaman utama scan QR untuk siswa
     */
    public function index()
    {
        return view('Absensi.scan');
    }

    public function scan(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'token'      => 'required|string',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        // 1. Validasi Token QR
        $qrToken = QrToken::where('token', $validated['token'])
            ->where('is_active', true)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$qrToken) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token QR tidak valid atau sudah kadaluarsa.'
            ], 400);
        }

        // 2. Cek apakah siswa sudah absen hari ini
        $today = Carbon::today();
        $alreadyScanned = Attendance::where('student_id', $validated['student_id'])
            ->whereDate('scanned_at', $today)
            ->exists();

        if ($alreadyScanned) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda sudah melakukan absensi hari ini.'
            ], 400);
        }

        // 3. Validasi Geofencing (Jarak ke Lokasi QR Aktif)
        $activeLocations = QrLocation::where('is_active', true)->get();

        if ($activeLocations->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada lokasi absensi aktif yang terdaftar.'
            ], 400);
        }

        $isWithinRadius = false;
        foreach ($activeLocations as $location) {
            $distance = $this->calculateHaversineDistance(
                $validated['latitude'],
                $validated['longitude'],
                $location->latitude,
                $location->longitude
            );

            if ($distance <= $location->radius_meters) {
                $isWithinRadius = true;
                break;
            }
        }

        if (!$isWithinRadius) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Posisi Anda berada di luar radius area absensi yang diizinkan.'
            ], 422);
        }

        // 4. Simpan Data Absensi
        $attendance = Attendance::create([
            'student_id' => $validated['student_id'],
            'scanned_at' => Carbon::now(),
            'status'     => 'Hadir',
            'latitude'   => $validated['latitude'],
            'longitude'  => $validated['longitude'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Absensi berhasil dicatat!',
            'data'    => $attendance->load('student')
        ], 201);
    }

    /**
     * Menghitung jarak antara dua koordinat GPS dalam satuan Meter (Haversine Formula)
     */
    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}