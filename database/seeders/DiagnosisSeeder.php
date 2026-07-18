<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diagnoses = [
            ['code' => 'A91', 'description' => 'Demam Berdarah Dengue (DBD)'],
            ['code' => 'A01.0', 'description' => 'Demam Tifoid (Tipes)'],
            ['code' => 'I10', 'description' => 'Hipertensi Esensial'],
            ['code' => 'J06.9', 'description' => 'Infeksi Saluran Pernapasan Akut (ISPA)'],
            ['code' => 'E11', 'description' => 'Diabetes Mellitus Tipe 2'],
            ['code' => 'J45', 'description' => 'Asma'],
            ['code' => 'K29.7', 'description' => 'Gastritis (Maag)'],
        ];

        foreach ($diagnoses as $diagnosis) {
            \App\Models\Diagnosis::firstOrCreate(['code' => $diagnosis['code']], $diagnosis);
        }
    }
}
