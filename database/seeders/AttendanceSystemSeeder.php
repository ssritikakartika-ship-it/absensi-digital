<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Student;
use App\Models\QrLocation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kelas Dummy
        $class1 = ClassModel::create([
            'nama_kelas' => 'X RPL 1',
            'kode_kelas' => 'XRPL1',
        ]);

        $class2 = ClassModel::create([
            'nama_kelas' => 'XI RPL 1',
            'kode_kelas' => 'XIRPL1',
        ]);

        // 2. Data User & Siswa Dummy
        $user1 = User::create([
            'name'     => 'Ahmad Santoso',
            'email'    => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'user_id'  => $user1->id,
            'class_id' => $class1->id,
            'nis'      => '1001',
            'nama'     => 'Ahmad Santoso',
        ]);

        $user2 = User::create([
            'name'     => 'Siti Rahma',
            'email'    => 'siti@gmail.com',
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'user_id'  => $user2->id,
            'class_id' => $class1->id,
            'nis'      => '1002',
            'nama'     => 'Siti Rahma',
        ]);

        $user3 = User::create([
            'name'     => 'Budi Pratama',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'user_id'  => $user3->id,
            'class_id' => $class2->id,
            'nis'      => '1003',
            'nama'     => 'Budi Pratama',
        ]);
// 3. Data Lokasi Scan / Geofencing Dummy
QrLocation::create([
    'nama_lokasi' => 'Gedung Utama Sekolah',
    'kode_lokasi' => 'LOK-UTAMA',
    'latitude'    => -6.917464,
    'longitude'   => 107.619123,
    'radius'      => 50,
    'status'      => true,
]);
    
    }
}