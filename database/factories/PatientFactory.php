<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->numerify('################'),
            'date_of_birth' => fake()->date('Y-m-d', '2015-01-01'),
            'gender' => fake()->randomElement(['M', 'F']),
            'phone' => substr(fake()->phoneNumber(), 0, 15),
            'address' => fake()->address(),
            'blood_type' => fake()->randomElement(['A', 'B', 'AB', 'O']),
        ];
    }
}
