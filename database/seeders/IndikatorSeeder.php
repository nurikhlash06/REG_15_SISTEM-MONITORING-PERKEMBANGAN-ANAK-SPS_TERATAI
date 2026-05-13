<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bagian1 = 'Nilai Agama dan Budi Pekerti';
        for ($i = 1; $i <= 21; $i++) {
            \App\Models\Indikator::create([
                'bagian' => $bagian1,
                'nama_indikator' => "Indikator {$bagian1} {$i}",
                'urutan' => $i,
            ]);
        }

        $bagian2 = 'Jati Diri';
        for ($i = 1; $i <= 6; $i++) {
            \App\Models\Indikator::create([
                'bagian' => $bagian2,
                'nama_indikator' => "Indikator {$bagian2} {$i}",
                'urutan' => $i,
            ]);
        }

        $bagian3 = 'Dasar Literasi, Matematika, Sains, Teknologi, Rekayasa & Seni';
        for ($i = 1; $i <= 70; $i++) {
            \App\Models\Indikator::create([
                'bagian' => $bagian3,
                'nama_indikator' => "Indikator {$bagian3} {$i}",
                'urutan' => $i,
            ]);
        }
    }
}
