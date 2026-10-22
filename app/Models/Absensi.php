<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id',
        'qr_token_id',
        'tanggal',
        'jam_masuk',
        'status',
    ];

    // Relasi ke tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    // Relasi ke tabel QrToken
    public function qrToken()
    {
        return $this->belongsTo(QrToken::class, 'qr_token_id');
    }
}