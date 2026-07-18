<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('patient.create') }}" role="button">Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">No. RM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $patient->medical_record_number }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->nik }}</td>
                            <td>{{ $patient->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('patient.show', $patient) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                <a href="{{ route('patient.edit', $patient) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('patient.destroy', $patient) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Patient</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })

            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memuat data",
                            icon: "error"
                        });
                    }
                });
            })
        </script>
    @endpush

</x-app>
