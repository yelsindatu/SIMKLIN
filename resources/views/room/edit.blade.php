<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('room.update', $room) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="name" class="form-label required">Nama Kamar</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                    name="name" required value="{{ old('name', $room->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3">{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('room.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
