<?php

namespace App\Observers;

use App\Models\Patient;

class PatientObserver
{
    /**
     * Handle the Patient "creating" event.
     */
    public function creating(Patient $patient): void
    {
        $lastPatient = Patient::orderBy('id', 'desc')->first();
        $nextId = $lastPatient ? $lastPatient->id + 1 : 1;
        $patient->medical_record_number = 'RM-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Handle the Patient "created" event.
     */
    public function created(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "updated" event.
     */
    public function updated(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "deleted" event.
     */
    public function deleted(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "restored" event.
     */
    public function restored(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "force deleted" event.
     */
    public function forceDeleted(Patient $patient): void
    {
        //
    }
}
