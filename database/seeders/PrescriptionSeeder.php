<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = \App\Models\MedicalRecord::all();
        $medicines = \App\Models\Medicine::all();

        if ($medicines->isEmpty()) {
            return;
        }

        foreach ($records as $record) {
            $numPrescriptions = rand(1, 3);
            for ($i = 0; $i < $numPrescriptions; $i++) {
                $med = $medicines->random();
                $qty = rand(1, 5);
                
                \App\Models\Prescription::create([
                    'medical_record_id' => $record->id,
                    'medicine_id' => $med->id,
                    'quantity' => $qty,
                    'dosage_instruction' => fake()->randomElement(['3 x 1 sesudah makan', '2 x 1 sebelum makan', '1 x 1 sebelum tidur']),
                ]);
            }
        }
    }
}
