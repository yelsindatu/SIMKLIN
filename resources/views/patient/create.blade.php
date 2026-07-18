<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('patient.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama</label>
                        <input class="form-control @error('name') is-invalid  @enderror" type="text" id="name"
                            name="name" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nik" class="form-label required">NIK (16 Digit)</label>
                        <input class="form-control @error('nik') is-invalid  @enderror" type="text" id="nik"
                            name="nik" required value="{{ old('nik') }}" maxlength="16" minlength="16">
                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label required">Tanggal Lahir</label>
                        <input class="form-control @error('date_of_birth') is-invalid  @enderror" type="date" id="date_of_birth"
                            name="date_of_birth" required value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label required">Jenis Kelamin</label>
                        <select class="form-select @error('gender') is-invalid  @enderror" id="gender"
                            name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="M" @selected(old('gender') == 'M')>Laki-laki</option>
                            <option value="F" @selected(old('gender') == 'F')>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. HP</label>
                        <input class="form-control @error('phone') is-invalid  @enderror" type="text" id="phone"
                            name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="blood_type" class="form-label">Golongan Darah</label>
                        <select class="form-select @error('blood_type') is-invalid  @enderror" id="blood_type"
                            name="blood_type">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" @selected(old('blood_type') == 'A')>A</option>
                            <option value="B" @selected(old('blood_type') == 'B')>B</option>
                            <option value="AB" @selected(old('blood_type') == 'AB')>AB</option>
                            <option value="O" @selected(old('blood_type') == 'O')>O</option>
                        </select>
                        @error('blood_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('patient.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
