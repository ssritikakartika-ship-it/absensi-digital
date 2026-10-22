<?php

namespace App\Http\Controllers;

use App\Models\QrLocation;
use Illuminate\Http\Request;

class QrLocationController extends Controller
{
    public function index()
    {
        $locations = QrLocation::paginate(10);
        return view('lokasi-qr', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_lokasi' => 'required',
            'nama_lokasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:1',
        ]);

        QrLocation::create([
            'kode_lokasi' => 'LOC-' . rand(100, 999),
            'nama_lokasi' => $request->nama_lokasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()->route('lokasi-qr.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_lokasi' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'radius' => 'required',
    ]);

    $location = \App\Models\QrLocation::findOrFail($id);
    $location->update([
        'nama_lokasi' => $request->nama_lokasi,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'radius' => $request->radius,
    ]);

    return redirect()->route('lokasi-qr.index')->with('success', 'Lokasi berhasil diupdate!');
}

    public function destroy($id)
    {
        $location = QrLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('lokasi-qr.index')->with('success', 'Lokasi GPS berhasil dihapus!');
    }
}