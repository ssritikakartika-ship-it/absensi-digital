<?php

namespace Database\Seeders;

use App\Models\ClassModel; // Sesuaikan dengan nama Model Kelas kamu
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassModelSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [];
        $grades = ['10', '11', '12'];
        
        $majors = [
            'RPL'  => 4, // RPL 1 - 4
            'TKJ'  => 4, // TKJ 1 - 4
            'ATPH' => 5, // ATPH 1 - 5
            'TAV'  => 3, // TAV 1 - 3
        ];

        foreach ($grades as $grade) {
            foreach ($majors as $major => $count) {
                for ($i = 1; $i <= $count; $i++) {
                    $namaKelas = "{$grade} {$major} {$i}";
                    $kodeKelas = "{$grade}-{$major}-{$i}"; // Contoh: 10-RPL-1

                    $classes[] = [
                        'kode_kelas' => $kodeKelas,
                        'nama_kelas' => $namaKelas,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        ClassModel::insert($classes);
    }
}