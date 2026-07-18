<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'type' => 'Tablet', 'price' => 5000, 'stock' => 500],
            ['name' => 'Amoxicillin 500mg', 'type' => 'Kapsul', 'price' => 12000, 'stock' => 300],
            ['name' => 'Cetirizine 10mg', 'type' => 'Tablet', 'price' => 8000, 'stock' => 400],
            ['name' => 'OBH Combi Plus', 'type' => 'Sirup', 'price' => 25000, 'stock' => 100],
            ['name' => 'Amlodipine 5mg', 'type' => 'Tablet', 'price' => 15000, 'stock' => 250],
            ['name' => 'Omeprazole 20mg', 'type' => 'Kapsul', 'price' => 20000, 'stock' => 200],
        ];

        foreach ($medicines as $medicine) {
            \App\Models\Medicine::firstOrCreate(['name' => $medicine['name']], $medicine);
        }
    }
}
