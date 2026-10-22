<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap tanggal dari request filter (Default: Hari Ini)
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        // 2. Data Ringkasan Atas (Berdasarkan rentang tanggal)
        $totalSiswa = Student::count();

        $hadir = Attendance::whereBetween('tanggal', [$startDate, $endDate])->where('status', 'hadir')->count();
        $jumlahIzin = Attendance::whereBetween('tanggal', [$startDate, $endDate])->where('status', 'izin')->count();
        $jumlahSakit = Attendance::whereBetween('tanggal', [$startDate, $endDate])->where('status', 'sakit')->count();
        $jumlahAlpha = Attendance::whereBetween('tanggal', [$startDate, $endDate])->where('status', 'alpha')->count();

        $belumHadir = max(0, $totalSiswa - ($hadir + $jumlahIzin + $jumlahSakit));
        $persentase = $totalSiswa > 0 ? round(($hadir / $totalSiswa) * 100) : 0;

        // 3. Data Absensi Terbaru (Tabel)
        $recentAttendances = Attendance::with(['student.class'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();

        // 4. Data Kehadiran Terbaik (Top Students)
        $topStudents = Attendance::selectRaw('student_id, count(*) as total_hadir')
            ->where('status', 'hadir')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('student_id')
            ->orderByDesc('total_hadir')
            ->take(5)
            ->with('student.class')
            ->get();

        // 5. Data Grafik Real
        $chartLabels = [];
        $chartData = [];

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Jika filter 1 hari, tampilkan rentang 7 hari ke belakang
        if ($start->equalTo($end)) {
            for ($i = 6; $i >= 0; $i--) {
                $date = $start->copy()->subDays($i);
                $chartLabels[] = $date->translatedFormat('D, d/m');
                $chartData[] = Attendance::whereDate('tanggal', $date)->where('status', 'hadir')->count();
            }
        } else {
            // Jika memilih rentang tanggal tertentu
            $period = CarbonPeriod::create($start, $end);
            foreach ($period as $date) {
                $chartLabels[] = $date->translatedFormat('D, d/m');
                $chartData[] = Attendance::whereDate('tanggal', $date)->where('status', 'hadir')->count();
            }
        }

        // Kirim semua data ke view
        return view('dashboard', compact(
            'totalSiswa',
            'hadir',
            'jumlahIzin',
            'jumlahSakit',
            'jumlahAlpha',
            'belumHadir',
            'persentase',
            'recentAttendances',
            'topStudents',
            'chartLabels',
            'chartData',
            'startDate',
            'endDate'
        ));
    }
}