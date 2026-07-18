<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col">Pasien</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Total Tagihan</th>
                        <th scope="col">Status</th>
                        <th scope="col" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->appointment->patient->name ?? '-' }}</td>
                            <td>{{ $invoice->appointment->doctor->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($invoice->status == 'Paid')
                                    <span class="badge bg-success">Lunas (Paid)</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas (Unpaid)</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('payment-invoice.show', $invoice) }}" class="btn btn-info btn-sm text-white">
                                    <i class='bx bx-search-alt'></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
