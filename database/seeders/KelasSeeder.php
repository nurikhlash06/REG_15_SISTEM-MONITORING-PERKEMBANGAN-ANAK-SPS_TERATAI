<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [
            [
                'nama_kelas' => 'Kelas A',
                'kode_kelas' => 'KEL-A',
                'deskripsi' => 'Kelas untuk tingkat A - Usia 4-5 tahun',
                'wali_kelas' => null,
                'tingkat' => 'A',
                'status' => 'aktif',
            ],
            [
                'nama_kelas' => 'Kelas B',
                'kode_kelas' => 'KEL-B',
                'deskripsi' => 'Kelas untuk tingkat B - Usia 5-6 tahun',
                'wali_kelas' => null,
                'tingkat' => 'B',
                'status' => 'aktif',
            ],
            [
                'nama_kelas' => 'Kelas B1',
                'kode_kelas' => 'KEL-B1',
                'deskripsi' => 'Kelas untuk tingkat B1 - Usia 6-7 tahun',
                'wali_kelas' => null,
                'tingkat' => 'B1',
                'status' => 'aktif',
            ],
        ];

        foreach ($kelasList as $kelas) {
            Kelas::create($kelas);
        }
    }
}
