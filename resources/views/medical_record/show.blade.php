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
        <table class="table table-bordered table-striped w-100 mb-4">
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

        @if($record->appointment->paymentInvoice)
            <h6 class="text-primary">Informasi Tagihan</h6>
            <table class="table table-bordered table-striped w-100">
                <tbody>
                    <tr>
                        <th width="30%">Total Tagihan</th>
                        <td>Rp {{ number_format($record->appointment->paymentInvoice->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            @if($record->appointment->paymentInvoice->status == 'Paid')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Detail Tagihan</th>
                        <td>
                            <a href="{{ route('payment-invoice.show', $record->appointment->paymentInvoice) }}" class="btn btn-sm btn-info text-white">Lihat Invoice</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col-md-12">
        <h6 class="text-primary">Daftar Resep Obat (E-Prescription)</h6>
        
        @if($record->status != 'locked')
            <form action="{{ route('prescription.store') }}" method="post" class="mb-3">
                @csrf
                <input type="hidden" name="medical_record_id" value="{{ $record->id }}">
                
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Pilih Obat</label>
                        <select class="form-select" name="medicine_id" required>
                            <option value="">-- Pilih Obat --</option>
                            @foreach(\App\Models\Medicine::where('stock', '>', 0)->orderBy('name')->get() as $med)
                                <option value="{{ $med->id }}">{{ $med->name }} (Stok: {{ $med->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="quantity" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Aturan Pakai</label>
                        <input type="text" class="form-control" name="dosage_instruction" placeholder="Contoh: 3x1 sesudah makan" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class='bx bx-plus'></i> Tambah</button>
                    </div>
                </div>
            </form>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-sm w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Obat</th>
                        <th width="10%">Jumlah</th>
                        <th>Aturan Pakai</th>
                        @if($record->status != 'locked')
                            <th width="10%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($record->prescriptions as $prescription)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $prescription->medicine->name }}</td>
                            <td>{{ $prescription->quantity }}</td>
                            <td>{{ $prescription->dosage_instruction }}</td>
                            @if($record->status != 'locked')
                                <td>
                                    <form action="{{ route('prescription.destroy', $prescription) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan resep ini?')">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $record->status == 'locked' ? 4 : 5 }}" class="text-center text-muted">Belum ada resep obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
