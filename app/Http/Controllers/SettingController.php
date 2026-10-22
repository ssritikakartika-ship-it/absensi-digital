<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function update(Request $request)
    {
        // Validasi dan simpan pengaturan aplikasi (misal: nama sekolah, jam masuk, jam pulang)
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jam_masuk'    => 'required',
            'jam_pulang'   => 'required',
        ]);

        // Simpan ke database / file config
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}