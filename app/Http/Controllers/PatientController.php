<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('patient.index', [
            'title' => 'Patient',
            'patients' => Patient::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('patient.create', [
            'title' => 'Create Patient',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'nik' => 'required|digits:16|unique:patients,nik',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'phone' => 'nullable|max:15',
            'address' => 'nullable',
            'blood_type' => 'nullable|in:A,B,AB,O',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'gender.required' => 'Jenis kelamin wajib diisi',
        ]);

        try {
            Patient::create($validate);
            return to_route('patient.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return to_route('patient.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Patient $patient)
    {
        return view('patient.show', [
            'title' => 'Detail Patient',
            'patient' => $patient,
        ]);
    }

    public function edit(Patient $patient)
    {
        return view('patient.edit', [
            'title' => 'Edit Patient',
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        $validate = $request->validate([
            'name' => 'required',
            'nik' => 'required|digits:16|unique:patients,nik,' . $patient->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'phone' => 'nullable|max:15',
            'address' => 'nullable',
            'blood_type' => 'nullable|in:A,B,AB,O',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'gender.required' => 'Jenis kelamin wajib diisi',
        ]);

        try {
            $patient->update($validate);
            return to_route('patient.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            return to_route('patient.edit', $patient)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return to_route('patient.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            return to_route('patient.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
