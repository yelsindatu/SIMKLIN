<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('medical_record.index', [
            'title' => 'Rekam Medis',
            'records' => MedicalRecord::with(['patient', 'doctor.user', 'appointment', 'diagnosis'])->latest()->get(),
        ]);
    }

    public function create(Request $request)
    {
        $appointment = \App\Models\Appointment::with(['patient', 'doctor.user'])->findOrFail($request->appointment_id);
        
        if (MedicalRecord::where('appointment_id', $appointment->id)->exists()) {
            return to_route('medical-record.index')->withError('Rekam medis untuk appointment ini sudah ada.');
        }

        return view('medical_record.create', [
            'title' => 'Buat Rekam Medis',
            'appointment' => $appointment,
            'diagnoses' => \App\Models\Diagnosis::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:medical_records,appointment_id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis_id' => 'nullable|exists:diagnoses,id',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'symptoms' => 'nullable|string',
            'physical_exam' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'status' => 'required|in:draft,locked',
        ]);

        try {
            $medicalRecord = MedicalRecord::create($validate);

            if ($request->status === 'locked') {
                $appointment = $medicalRecord->appointment;
                $appointment->update([
                    'status' => 'Completed'
                ]);
                
                // Generate Invoice
                // At this point, there's no prescription because the RM was just created.
                // So medicineFee is 0.
                $medicineFee = 0;
                $doctorFee = 50000;
                \App\Models\PaymentInvoice::create([
                    'appointment_id' => $appointment->id,
                    'doctor_fee' => $doctorFee,
                    'medicine_fee' => $medicineFee,
                    'total_amount' => $doctorFee + $medicineFee,
                    'status' => 'Unpaid',
                ]);

                return to_route('medical-record.index')->withSuccess('Rekam medis berhasil disimpan dan dikunci. Tagihan otomatis terbuat.');
            }

            return to_route('medical-record.index')->withSuccess('Rekam medis berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor.user', 'appointment', 'diagnosis']);
        return view('medical_record.show', [
            'title' => 'Detail Rekam Medis',
            'record' => $medicalRecord,
        ]);
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->status === 'locked') {
            return to_route('medical-record.index')->withError('Rekam medis yang sudah di-lock tidak dapat diubah.');
        }

        $medicalRecord->load(['patient', 'doctor.user', 'appointment']);
        
        return view('medical_record.edit', [
            'title' => 'Ubah Rekam Medis',
            'record' => $medicalRecord,
            'diagnoses' => \App\Models\Diagnosis::all(),
        ]);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->status === 'locked') {
            return to_route('medical-record.index')->withError('Rekam medis yang sudah di-lock tidak dapat diubah.');
        }

        $validate = $request->validate([
            'diagnosis_id' => 'nullable|exists:diagnoses,id',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'symptoms' => 'nullable|string',
            'physical_exam' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'status' => 'required|in:draft,locked',
        ]);

        try {
            $medicalRecord->update($validate);

            if ($request->status === 'locked') {
                $appointment = $medicalRecord->appointment;
                $appointment->update([
                    'status' => 'Completed'
                ]);
                
                // Generate Invoice
                $medicineFee = 0;
                foreach ($medicalRecord->prescriptions as $prescription) {
                    $medicineFee += $prescription->quantity * $prescription->medicine->price;
                }
                $doctorFee = 50000;
                \App\Models\PaymentInvoice::create([
                    'appointment_id' => $appointment->id,
                    'doctor_fee' => $doctorFee,
                    'medicine_fee' => $medicineFee,
                    'total_amount' => $doctorFee + $medicineFee,
                    'status' => 'Unpaid',
                ]);

                return back()->withSuccess('Rekam medis berhasil dikunci. Tagihan otomatis terbuat.');
            }

            return to_route('medical-record.index')->withSuccess('Rekam medis berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->status === 'locked') {
            return to_route('medical-record.index')->withError('Rekam medis yang sudah di-lock tidak dapat dihapus.');
        }

        try {
            $medicalRecord->delete();
            return to_route('medical-record.index')->withSuccess('Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return to_route('medical-record.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
