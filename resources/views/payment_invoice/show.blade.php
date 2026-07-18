<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h5 class="mb-3">Tagihan Kepada:</h5>
                <div>
                    <strong>Pasien:</strong> {{ $invoice->appointment->patient->name ?? '-' }}<br>
                    <strong>No. RM:</strong> {{ $invoice->appointment->patient->medical_record_number ?? '-' }}<br>
                    <strong>Dokter:</strong> {{ $invoice->appointment->doctor->user->name ?? '-' }}
                </div>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h5 class="mb-3">Detail Invoice:</h5>
                <div>
                    <strong>Invoice ID:</strong> #INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}<br>
                    <strong>Tanggal:</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Status:</strong> 
                    @if($invoice->status == 'Paid')
                        <span class="badge bg-success fs-6">Lunas</span>
                    @else
                        <span class="badge bg-danger fs-6">Belum Lunas</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="center">#</th>
                        <th>Keterangan</th>
                        <th class="right">Harga Satuan</th>
                        <th class="center">Qty</th>
                        <th class="right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center">1</td>
                        <td class="left">Jasa Pemeriksaan / Konsultasi Dokter</td>
                        <td class="right">Rp {{ number_format($invoice->doctor_fee, 0, ',', '.') }}</td>
                        <td class="center">1</td>
                        <td class="right">Rp {{ number_format($invoice->doctor_fee, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->appointment->medicalRecord)
                        @foreach($invoice->appointment->medicalRecord->prescriptions as $idx => $prescription)
                        <tr>
                            <td class="center">{{ $idx + 2 }}</td>
                            <td class="left">Obat: {{ $prescription->medicine->name }}</td>
                            <td class="right">Rp {{ number_format($prescription->medicine->price, 0, ',', '.') }}</td>
                            <td class="center">{{ $prescription->quantity }}</td>
                            <td class="right">Rp {{ number_format($prescription->quantity * $prescription->medicine->price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-5 ms-auto">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td class="left"><strong>Subtotal Obat</strong></td>
                            <td class="right">Rp {{ number_format($invoice->medicine_fee, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="left"><strong>Jasa Dokter</strong></td>
                            <td class="right">Rp {{ number_format($invoice->doctor_fee, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="left"><strong>Total Keseluruhan</strong></td>
                            <td class="right"><strong>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                
                @if($invoice->status == 'Unpaid')
                <form action="{{ route('payment-invoice.update', $invoice) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success w-100 mt-2" onclick="return confirm('Proses pembayaran untuk tagihan ini?')">
                        <i class='bx bx-money'></i> Proses Pembayaran
                    </button>
                </form>
                @endif
                
                <a href="{{ route('payment-invoice.index') }}" class="btn btn-secondary w-100 mt-2">Kembali</a>
            </div>
        </div>
    </div>
</x-app>
