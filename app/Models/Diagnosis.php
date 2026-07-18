<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    /** @use HasFactory<\Database\Factories\DiagnosisFactory> */
    use HasFactory;

    protected $fillable = ['code', 'description'];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
