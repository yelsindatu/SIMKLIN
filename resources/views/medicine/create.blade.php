<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('medicine.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Obat/Alkes</label>
                        <input class="form-control @error('name') is-invalid  @enderror" type="text" id="name"
                            name="name" required value="{{ old('name') }}" placeholder="Contoh: Paracetamol 500mg">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label required">Jenis</label>
                        <select class="form-select @error('type') is-invalid  @enderror" id="type"
                            name="type" required>
                            <option value="Tablet" @selected(old('type') == 'Tablet')>Tablet</option>
                            <option value="Kapsul" @selected(old('type') == 'Kapsul')>Kapsul</option>
                            <option value="Sirup" @selected(old('type') == 'Sirup')>Sirup</option>
                            <option value="Salep" @selected(old('type') == 'Salep')>Salep</option>
                            <option value="Ampul" @selected(old('type') == 'Ampul')>Ampul</option>
                            <option value="Lainnya" @selected(old('type') == 'Lainnya')>Lainnya</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label required">Harga (Rp)</label>
                        <input class="form-control @error('price') is-invalid  @enderror" type="text" id="price"
                            name="price" required value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label required">Stok</label>
                        <input class="form-control @error('stock') is-invalid  @enderror" type="number" id="stock"
                            name="stock" required value="{{ old('stock') }}">
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('medicine.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
