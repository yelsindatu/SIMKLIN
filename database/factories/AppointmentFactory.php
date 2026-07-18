<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()->id ?? \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()->id ?? \App\Models\Doctor::factory(),
            'appointment_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d H:00:00'),
            'status' => fake()->randomElement(['scheduled', 'completed', 'cancelled']),
            'notes' => fake()->sentence(),
        ];
    }
}
