<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a class="btn btn-primary" href="{{ route('nurse-schedule.create') }}" role="button">Tambah Jadwal</a>
            
            <form action="{{ route('nurse-schedule.index') }}" method="GET" class="d-flex">
                <input type="date" name="date" class="form-control me-2" value="{{ request('date', date('Y-m-d')) }}">
                <button type="submit" class="btn btn-secondary">Filter Tanggal</button>
                @if(request()->has('date'))
                    <a href="{{ route('nurse-schedule.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Shift</th>
                        <th scope="col">Perawat</th>
                        <th scope="col">Kamar / Ruangan</th>
                        <th scope="col" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }}</td>
                            <td>
                                @if($schedule->shift == 'Pagi')
                                    <span class="badge bg-info"><i class='bx bx-sun'></i> Pagi</span>
                                @elseif($schedule->shift == 'Sore')
                                    <span class="badge bg-warning text-dark"><i class='bx bx-cloud'></i> Sore</span>
                                @else
                                    <span class="badge bg-dark"><i class='bx bx-moon'></i> Malam</span>
                                @endif
                            </td>
                            <td>{{ $schedule->user->name ?? '-' }}</td>
                            <td>{{ $schedule->room->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('nurse-schedule.edit', $schedule) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('nurse-schedule.destroy', $schedule) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada jadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush
</x-app>
