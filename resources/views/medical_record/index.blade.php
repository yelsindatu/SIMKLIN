<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tgl Periksa</th>
                        <th scope="col">Pasien</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Diagnosis</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $record->patient->name }}</td>
                            <td>{{ $record->doctor->user->name }}</td>
                            <td>{{ $record->diagnosis?->code ?? '-' }}</td>
                            <td>
                                @if($record->status == 'locked')
                                    <span class="badge text-bg-success"><i class='bx bx-lock-alt'></i> Locked</span>
                                @else
                                    <span class="badge text-bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('medical-record.show', $record) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                @if($record->status != 'locked')
                                    <a href="{{ route('medical-record.edit', $record) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-route="{{ route('medical-record.destroy', $record) }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                @endif
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Rekam Medis</h1>
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
