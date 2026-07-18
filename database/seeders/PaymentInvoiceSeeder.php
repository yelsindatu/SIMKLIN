<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = \App\Models\Appointment::where('status', 'Completed')->doesntHave('paymentInvoice')->get();
        
        foreach ($appointments as $index => $appointment) {
            $medicalRecord = $appointment->medicalRecord;
            
            if ($medicalRecord) {
                $medicineFee = 0;
                foreach ($medicalRecord->prescriptions as $prescription) {
                    $medicineFee += $prescription->quantity * $prescription->medicine->price;
                }
                
                $doctorFee = 50000;
                $totalAmount = $doctorFee + $medicineFee;
                
                \App\Models\PaymentInvoice::create([
                    'appointment_id' => $appointment->id,
                    'doctor_fee' => $doctorFee,
                    'medicine_fee' => $medicineFee,
                    'total_amount' => $totalAmount,
                    'status' => $index % 2 == 0 ? 'Paid' : 'Unpaid',
                ]);
            }
        }
    }
}
