<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingUsers = \App\Models\User::where('role', 'Dokter')->get();
        foreach ($existingUsers as $user) {
            \App\Models\Doctor::factory()->create(['user_id' => $user->id]);
        }
        
        $newUsers = \App\Models\User::factory(4)->create(['role' => 'Dokter']);
        foreach ($newUsers as $user) {
            \App\Models\Doctor::factory()->create(['user_id' => $user->id]);
        }
    }
}
