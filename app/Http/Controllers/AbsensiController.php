<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Student;
use App\Models\QrToken;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data absensi beserta relasi ke siswa dan token, dengan fitur pencarian tanggal/nama
        $query = Absensi::with(['siswa.kelas', 'qrToken.location']);

        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->where('tanggal', $request->tanggal);
        }

        $absensis = $query->latest()->paginate(10)->withQueryString();

        return view('absensi.index', compact('absensis'));
    }

    public function laporan(Request $request)
    {
        $query = Absensi::with(['siswa.class', 'qrToken.location']);

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $absensis = $query->latest()->get();

        return view('absensi.laporan', compact('absensis'));
    }

    // Menampilkan halaman scan QR untuk siswa
    public function scanForm()
    {
        return view('absensi.scan');
    }

    // Proses menyimpan absensi dari hasil scan
    public function storeScan(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'token' => 'required',
        ]);

        // Cari data siswa berdasarkan NIS menggunakan model Student
        $siswa = Student::where('nis', $request->nis)->first();
        if (!$siswa) {
            return back()->with('error', 'NIS tidak ditemukan!');
        }

        // Cari token QR yang aktif menggunakan model QrToken
        $qrToken = QrToken::where('token', $request->token)->first();
        if (!$qrToken) {
            return back()->with('error', 'Token QR tidak valid atau sudah kedaluwarsa!');
        }

        // Cek apakah siswa sudah absen hari ini
        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini!');
        }

        // Simpan data absensi
        Absensi::create([
            'siswa_id' => $siswa->id,
            'qr_token_id' => $qrToken->id,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'status' => 'Hadir',
        ]);

        return back()->with('success', 'Absensi atas nama ' . $siswa->nama . ' berhasil direkam!');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}