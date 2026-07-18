<table class="table table-bordered table-striped w-100">
    <tbody>
        <tr>
            <th width="30%">Nama Pasien</th>
            <td>{{ $appointment->patient->name }} ({{ $appointment->patient->medical_record_number }})</td>
        </tr>
        <tr>
            <th>Dokter</th>
            <td>{{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialization }})</td>
        </tr>
        <tr>
            <th>Tanggal & Waktu</th>
            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($appointment->status == 'scheduled')
                    <span class="badge text-bg-warning">Scheduled</span>
                @elseif($appointment->status == 'completed')
                    <span class="badge text-bg-success">Completed</span>
                @else
                    <span class="badge text-bg-danger">Cancelled</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Catatan/Keluhan</th>
            <td>{!! nl2br(e($appointment->notes ?? '-')) !!}</td>
        </tr>
    </tbody>
</table>
