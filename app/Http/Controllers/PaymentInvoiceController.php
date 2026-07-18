<?php

namespace App\Http\Controllers;

use App\Models\PaymentInvoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = \App\Models\PaymentInvoice::with(['appointment.patient', 'appointment.doctor'])->latest()->get();
        return view('payment_invoice.index', [
            'title' => 'Tagihan & Pembayaran',
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        abort(404);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        abort(404);
    }

    public function show(\App\Models\PaymentInvoice $paymentInvoice)
    {
        $paymentInvoice->load(['appointment.patient', 'appointment.doctor', 'appointment.medicalRecord.prescriptions.medicine']);
        
        return view('payment_invoice.show', [
            'title' => 'Rincian Tagihan',
            'invoice' => $paymentInvoice,
        ]);
    }

    public function edit(\App\Models\PaymentInvoice $paymentInvoice)
    {
        abort(404);
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\PaymentInvoice $paymentInvoice)
    {
        try {
            $paymentInvoice->update(['status' => 'Paid']);
            return back()->withSuccess('Pembayaran berhasil diproses.');
        } catch (\Exception $e) {
            return back()->withError('Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function destroy(\App\Models\PaymentInvoice $paymentInvoice)
    {
        abort(404);
    }
}
