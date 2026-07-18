<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('nurse-schedule.update', $schedule) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date" class="form-label required">Tanggal</label>
                    <input class="form-control @error('date') is-invalid @enderror" type="date" id="date"
                        name="date" required value="{{ old('date', $schedule->date) }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="shift" class="form-label required">Shift</label>
                    <select class="form-select @error('shift') is-invalid @enderror" id="shift" name="shift" required>
                        <option value="">-- Pilih Shift --</option>
                        <option value="Pagi" @selected(old('shift', $schedule->shift) == 'Pagi')>Pagi (07:00 - 15:00)</option>
                        <option value="Sore" @selected(old('shift', $schedule->shift) == 'Sore')>Sore (15:00 - 22:00)</option>
                        <option value="Malam" @selected(old('shift', $schedule->shift) == 'Malam')>Malam (22:00 - 07:00)</option>
                    </select>
                    @error('shift')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label required">Perawat</label>
                <select class="form-select select2 @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                    <option value="">-- Pilih Perawat --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $schedule->user_id) == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="room_id" class="form-label required">Kamar / Ruangan</label>
                <select class="form-select select2 @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                    <option value="">-- Pilih Kamar --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" @selected(old('room_id', $schedule->room_id) == $room->id)>{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('room_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('nurse-schedule.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
