<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classrooms';

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}