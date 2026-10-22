<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Absensi;

class StudentPortalController extends Controller
{
    // Helper otomatis pencarian data siswa
    private function getStudentLogin()
    {
        $user = Auth::user();
        if (!$user) return null;

        return Student::where('user_id', $user->id ?? null)
            ->orWhere('nis', $user->nis ?? null)
            ->first() ?? Student::first();
    }

    public function beranda(Request $request)
    {
        $student = $this->getStudentLogin();
        $riwayat = [];
        $absensiHariIni = null;
        $nis = $student ? $student->nis : null;

        if ($student) {
            $riwayat = Absensi::where('siswa_id', $student->id)->with('qrToken.location')->latest()->get();
            $absensiHariIni = Absensi::where('siswa_id', $student->id)
                ->whereDate('created_at', today())
                ->first();
        }

        return view('student.beranda', compact('student', 'riwayat', 'nis', 'absensiHariIni'));
    }

    public function scan(Request $request)
    {
        $student = $this->getStudentLogin();
        $nis = $student ? $student->nis : null;
        return view('student.scan', compact('nis', 'student'));
    }

    public function profil(Request $request)
    {
        $student = $this->getStudentLogin();
        $nis = $student ? $student->nis : null;
        return view('student.profil', compact('student', 'nis'));
    }

    public function absensi(Request $request)
    {
        $student = $this->getStudentLogin();
        $nis = $student ? $student->nis : null;
        return view('student.absensi', compact('student', 'nis'));
    }

    public function jadwal(Request $request)
    {
        $student = $this->getStudentLogin();
        $nis = $student ? $student->nis : null;
        return view('student.jadwal', compact('student', 'nis'));
    }

    public function riwayat(Request $request)
    {
        $student = $this->getStudentLogin();
        $riwayat = [];
        $nis = $student ? $student->nis : null;

        if ($student) {
            $riwayat = Absensi::where('siswa_id', $student->id)->with('qrToken.location')->latest()->get();
        }

        return view('student.riwayat', compact('student', 'riwayat', 'nis'));
    }
}