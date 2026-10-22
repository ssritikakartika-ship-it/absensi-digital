<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'class_id',
    ];

    // Relasi utama
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Tambahkan alias relasi ini agar memanggil 'kelas' tidak error
    public function kelas()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}