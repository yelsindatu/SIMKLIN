<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'dosage_instruction' => 'required|string',
        ]);

        $medicine = \App\Models\Medicine::find($validate['medicine_id']);

        if ($medicine->stock < $validate['quantity']) {
            return back()->withInput()->withError('Stok obat ' . $medicine->name . ' tidak mencukupi. Sisa stok: ' . $medicine->stock);
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            Prescription::create($validate);
            $medicine->decrement('stock', $validate['quantity']);

            \Illuminate\Support\Facades\DB::commit();

            return back()->withSuccess('Resep obat berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withError('Gagal menambahkan resep: ' . $e->getMessage());
        }
    }

    public function destroy(Prescription $prescription)
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $medicine = $prescription->medicine;
            $qty = $prescription->quantity;

            $prescription->delete();
            $medicine->increment('stock', $qty);

            \Illuminate\Support\Facades\DB::commit();

            return back()->withSuccess('Resep obat berhasil dibatalkan dan stok dikembalikan.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withError('Gagal membatalkan resep: ' . $e->getMessage());
        }
    }
}
