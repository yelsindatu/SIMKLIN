<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('appointment.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="patient_id" class="form-label required">Pasien</label>
                        <select class="form-select @error('patient_id') is-invalid  @enderror" id="patient_id"
                            name="patient_id" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>{{ $patient->name }} ({{ $patient->medical_record_number }})</option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="doctor_id" class="form-label required">Dokter</label>
                        <select class="form-select @error('doctor_id') is-invalid  @enderror" id="doctor_id"
                            name="doctor_id" required>
                            <option value="">Pilih Dokter</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>{{ $doctor->user->name }} - {{ $doctor->specialization }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="appointment_date" class="form-label required">Tanggal & Jam Pertemuan</label>
                        <input class="form-control @error('appointment_date') is-invalid  @enderror" type="datetime-local" id="appointment_date"
                            name="appointment_date" required value="{{ old('appointment_date') }}">
                        @error('appointment_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select @error('status') is-invalid  @enderror" id="status"
                            name="status" required>
                            <option value="scheduled" @selected(old('status') == 'scheduled')>Scheduled</option>
                            <option value="completed" @selected(old('status') == 'completed')>Completed</option>
                            <option value="cancelled" @selected(old('status') == 'cancelled')>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Keluhan (Opsional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('appointment.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
