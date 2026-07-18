<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInvoice extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentInvoiceFactory> */
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'doctor_fee',
        'medicine_fee',
        'total_amount',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
