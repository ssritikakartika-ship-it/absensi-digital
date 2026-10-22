<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Menampilkan daftar notifikasi sistem / aktivitas terbaru
        return view('notifikasi.index');
    }
}