<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    /** @use HasFactory<\Database\Factories\MedicalRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'diagnosis_id',
        'blood_pressure',
        'temperature',
        'symptoms',
        'physical_exam',
        'treatment_plan',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
