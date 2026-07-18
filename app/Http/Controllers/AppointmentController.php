<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('appointment.index', [
            'title' => 'Appointment',
            'appointments' => Appointment::with(['patient', 'doctor.user'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('appointment.create', [
            'title' => 'Create Appointment',
            'patients' => \App\Models\Patient::orderBy('name')->get(),
            'doctors' => \App\Models\Doctor::with('user')->get()->sortBy('user.name'),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable',
        ]);

        $appointmentDate = date('Y-m-d H:i:s', strtotime($validate['appointment_date']));

        $conflict = Appointment::where('doctor_id', $validate['doctor_id'])
            ->where('appointment_date', $appointmentDate)
            ->where('status', 'scheduled')
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors(['appointment_date' => 'Dokter sudah memiliki jadwal pada waktu tersebut.']);
        }

        $validate['appointment_date'] = $appointmentDate;

        try {
            Appointment::create($validate);
            return to_route('appointment.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return to_route('appointment.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user']);
        return view('appointment.show', [
            'title' => 'Detail Appointment',
            'appointment' => $appointment,
        ]);
    }

    public function edit(Appointment $appointment)
    {
        return view('appointment.edit', [
            'title' => 'Edit Appointment',
            'appointment' => $appointment,
            'patients' => \App\Models\Patient::orderBy('name')->get(),
            'doctors' => \App\Models\Doctor::with('user')->get()->sortBy('user.name'),
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validate = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable',
        ]);

        $appointmentDate = date('Y-m-d H:i:s', strtotime($validate['appointment_date']));

        $conflict = Appointment::where('id', '!=', $appointment->id)
            ->where('doctor_id', $validate['doctor_id'])
            ->where('appointment_date', $appointmentDate)
            ->where('status', 'scheduled')
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors(['appointment_date' => 'Dokter sudah memiliki jadwal pada waktu tersebut.']);
        }

        $validate['appointment_date'] = $appointmentDate;

        try {
            $appointment->update($validate);
            return to_route('appointment.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            return to_route('appointment.edit', $appointment)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->delete();
            return to_route('appointment.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            return to_route('appointment.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
