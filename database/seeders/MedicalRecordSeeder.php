<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $completedAppointments = \App\Models\Appointment::where('status', 'completed')->get();
        foreach ($completedAppointments as $appointment) {
            if (!\App\Models\MedicalRecord::where('appointment_id', $appointment->id)->exists()) {
                \App\Models\MedicalRecord::factory()->create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'diagnosis_id' => \App\Models\Diagnosis::inRandomOrder()->first()->id,
                ]);
            }
        }
    }
}
