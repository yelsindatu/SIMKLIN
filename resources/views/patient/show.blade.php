<table class="table table-bordered table-striped w-100">
    <tbody>
        <tr>
            <th width="30%">No. Rekam Medis</th>
            <td>{{ $patient->medical_record_number }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $patient->name }}</td>
        </tr>
        <tr>
            <th>NIK</th>
            <td>{{ $patient->nik }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $patient->date_of_birth }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $patient->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <th>No. HP</th>
            <td>{{ $patient->phone ?? '-' }}</td>
        </tr>
        <tr>
            <th>Golongan Darah</th>
            <td>{{ $patient->blood_type ?? '-' }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $patient->address ?? '-' }}</td>
        </tr>
    </tbody>
</table>
