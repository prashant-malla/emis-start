<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sname' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'admission' => fake()->unique()->randomNumber(6, false),
            'roll' => fake()->unique()->randomNumber(3),
            'ethnicity' => ETHNICITY_TYPES[0],
            'level_id' => 1,
            'program_id' => 1,
            'year_semester_id' => 1,
            'section_id' => 1,
            'gender' => collect(GENDER_TYPES)->random(),
            'bloodgroup' => BLOOD_GROUPS_TYPES[0],
        ];
    }
}
