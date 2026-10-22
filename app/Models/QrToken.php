<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'qr_tokens';

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'qr_location_id',
        'token',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Relasi ke tabel qr_locations
    public function location()
    {
        return $this->belongsTo(QrLocation::class, 'qr_location_id');
    }
}