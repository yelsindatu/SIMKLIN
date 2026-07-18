<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['name' => 'Ruang Triage', 'description' => 'Ruangan untuk observasi awal pasien'],
            ['name' => 'Ruang Periksa 1', 'description' => 'Ruang periksa dokter umum'],
            ['name' => 'Ruang Periksa 2', 'description' => 'Ruang periksa spesialis'],
            ['name' => 'Ruang Tindakan', 'description' => 'Ruangan untuk tindakan medis'],
        ];

        foreach ($rooms as $room) {
            \App\Models\Room::firstOrCreate(['name' => $room['name']], $room);
        }
    }
}
