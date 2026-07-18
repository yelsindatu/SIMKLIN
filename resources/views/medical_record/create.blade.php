<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <h5 class="mb-4">RM: {{ $appointment->patient->name }} | Dr. {{ $appointment->doctor->user->name }}</h5>
        
        <form action="{{ route('medical-record.store') }}" method="post" class="form">
            @csrf
            
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
            <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <h6 class="text-primary">Tanda Vital (Perawat)</h6>
                    <div class="mb-3">
                        <label for="blood_pressure" class="form-label">Tekanan Darah</label>
                        <input class="form-control @error('blood_pressure') is-invalid @enderror" type="text" id="blood_pressure"
                            name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="Contoh: 120/80">
                    </div>
                    <div class="mb-3">
                        <label for="temperature" class="form-label">Suhu Tubuh (°C)</label>
                        <input class="form-control @error('temperature') is-invalid @enderror" type="number" step="0.1" id="temperature"
                            name="temperature" value="{{ old('temperature') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="text-primary">Pemeriksaan & Diagnosis (Dokter)</h6>
                    <div class="mb-3">
                        <label for="symptoms" class="form-label">S - Subjective (Keluhan)</label>
                        <textarea class="form-control" id="symptoms" name="symptoms" rows="2">{{ old('symptoms', $appointment->notes) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="physical_exam" class="form-label">O - Objective (Pemeriksaan Fisik)</label>
                        <textarea class="form-control" id="physical_exam" name="physical_exam" rows="2">{{ old('physical_exam') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis_id" class="form-label">A - Assessment (Diagnosis)</label>
                        <select class="form-select" id="diagnosis_id" name="diagnosis_id">
                            <option value="">Pilih Diagnosis</option>
                            @foreach($diagnoses as $diag)
                                <option value="{{ $diag->id }}" @selected(old('diagnosis_id') == $diag->id)>{{ $diag->code }} - {{ $diag->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_plan" class="form-label">P - Plan (Tindakan/Rencana)</label>
                        <textarea class="form-control" id="treatment_plan" name="treatment_plan" rows="2">{{ old('treatment_plan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3 border-top pt-3">
                <label for="status" class="form-label required">Status Simpan</label>
                <select class="form-select w-auto @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" @selected(old('status') == 'draft')>Draft (Masih bisa diedit)</option>
                    <option value="locked" @selected(old('status') == 'locked')>Locked (Simpan Final, Tidak bisa diedit)</option>
                </select>
            </div>

            <div class="text-end">
                <a href="{{ route('appointment.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan RM</button>
            </div>
        </form>
    </div>
</x-app>
