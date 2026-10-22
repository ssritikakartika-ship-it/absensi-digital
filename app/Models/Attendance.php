<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'scanned_at',
        'status',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'latitude'   => 'float',
        'longitude'  => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}