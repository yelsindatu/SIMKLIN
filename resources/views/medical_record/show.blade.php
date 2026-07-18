<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered table-striped w-100">
            <tbody>
                <tr>
                    <th width="40%">Waktu Pemeriksaan</th>
                    <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Pasien</th>
                    <td>{{ $record->patient->name }} ({{ $record->patient->medical_record_number }})</td>
                </tr>
                <tr>
                    <th>Dokter Pemeriksa</th>
                    <td>{{ $record->doctor->user->name }} ({{ $record->doctor->specialization }})</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($record->status == 'locked')
                            <span class="badge text-bg-success"><i class='bx bx-lock-alt'></i> Locked</span>
                        @else
                            <span class="badge text-bg-warning">Draft</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        
        <h6 class="mt-4 text-primary">Tanda Vital (Perawat)</h6>
        <table class="table table-bordered table-striped w-100">
            <tbody>
                <tr>
                    <th width="40%">Tekanan Darah</th>
                    <td>{{ $record->blood_pressure ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Suhu Tubuh</th>
                    <td>{{ $record->temperature ? $record->temperature . ' °C' : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="text-primary">SOAP & Diagnosis (Dokter)</h6>
        <table class="table table-bordered table-striped w-100">
            <tbody>
                <tr>
                    <th width="30%">S - Subjective</th>
                    <td>{!! nl2br(e($record->symptoms ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>O - Objective</th>
                    <td>{!! nl2br(e($record->physical_exam ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>A - Assessment</th>
                    <td>
                        @if($record->diagnosis)
                            <strong>{{ $record->diagnosis->code }}</strong> - {{ $record->diagnosis->description }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>P - Plan</th>
                    <td>{!! nl2br(e($record->treatment_plan ?? '-')) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
