<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Models\QrLocation;
use Illuminate\Support\Str;

class QrTokenController extends Controller
{
    // Menampilkan halaman daftar token QR
    public function index()
    {
        $tokens = QrToken::with('location')->latest()->paginate(10);
        $locations = QrLocation::all(); // Untuk pilihan lokasi di modal
        
        return view('token-qr', compact('tokens', 'locations'));
    }

    // Menyimpan token QR baru
    public function store(Request $request)
    {
        $request->validate([
            'qr_location_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        QrToken::create([
            'qr_location_id' => $request->qr_location_id,
            'token' => strtoupper(Str::random(6)), // Generate token acak 6 karakter
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'Aktif',
        ]);

        return redirect()->route('token-qr.index')->with('success', 'Token QR berhasil digenerate!');
    }

    // Menghapus token QR
    public function destroy($id)
    {
        $token = QrToken::findOrFail($id);
        $token->delete();

        return redirect()->route('token-qr.index')->with('success', 'Token QR berhasil dihapus!');
    }
}