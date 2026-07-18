<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blood_pressure' => fake()->randomElement(['120/80', '130/90', '110/70', '140/90']),
            'temperature' => fake()->randomFloat(1, 36.0, 40.0),
            'symptoms' => fake()->paragraph(),
            'physical_exam' => fake()->paragraph(),
            'treatment_plan' => fake()->paragraph(),
            'status' => 'locked',
        ];
    }
}
