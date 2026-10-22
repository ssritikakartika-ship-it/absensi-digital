<?php

namespace App\Http\Controllers;

use App\Models\QrToken;
use App\Models\QrLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenPageController extends Controller
{
    public function index()
    {
        $tokens = QrToken::with('qrLocation')->latest()->get();
        $locations = QrLocation::all();

        // Memanggil file resources/views/qr-tokens/index.blade.php
        return view('qr-tokens.index', compact('tokens', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'qr_location_id' => 'required|exists:qr_locations,id',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_berakhir' => 'required',
            'status'         => 'required|boolean',
        ]);

        QrToken::create([
            'qr_location_id' => $request->qr_location_id,
            'token'          => Str::random(64),
            'tanggal'        => $request->tanggal,
            'waktu_mulai'    => $request->waktu_mulai,
            'waktu_berakhir' => $request->waktu_berakhir,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('token-qr.index')
            ->with('success', 'Token QR berhasil dibuat.');
    }
}