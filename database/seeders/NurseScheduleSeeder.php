<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nurses = \App\Models\User::where('role', 'Perawat')->get();
        $rooms = \App\Models\Room::all();

        if ($nurses->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        $startDate = \Carbon\Carbon::now();
        $shifts = ['Pagi', 'Sore', 'Malam'];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            
            foreach ($shifts as $shift) {
                // To avoid rule 1 (same nurse same shift different room), we'll shuffle nurses
                $shuffledNurses = $nurses->shuffle();
                $nurseIndex = 0;
                
                foreach ($rooms as $room) {
                    if ($nurseIndex >= $shuffledNurses->count()) {
                        break;
                    }
                    $nurse = $shuffledNurses[$nurseIndex];
                    
                    \App\Models\NurseSchedule::firstOrCreate([
                        'user_id' => $nurse->id,
                        'date' => $date,
                        'shift' => $shift,
                    ], [
                        'room_id' => $room->id,
                    ]);
                    
                    $nurseIndex++;
                }
            }
        }
    }
}
