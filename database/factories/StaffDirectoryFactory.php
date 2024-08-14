<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StaffDirectory>
 */
class StaffDirectoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'staff_id' => fake()->unique()->randomNumber(6, false),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => fake()->unique()->numberBetween(9000000000, 9999999999),
            'gender' => collect(GENDER_TYPES)->random(),
            'dob' => '2040-01-01',
            'marital_status' => MARITAL_STATUS_TYPES[0],
            'permanent_address' => fake()->address(),
            'current_address' => fake()->address(),
            'qualification' => 'Bachelors',
            'work_experience' => '1 year',
            'father_name' => fake()->name('male'),
            'mother_name' => fake()->name('female'),
            'emergency_phone' => fake()->numberBetween(9000000000, 9999999999),
            'ethnicity' => 'EDJ',
            'role_id' => '5',
            'department_id' => '1',
            'designation_id' => '2',
            'date_of_joining' => '2070-01-01',
            'pan_number' => Str::random(7),
            'service_type' => 'permanent',
            'work_shift' => 'Day',
            'basic_salary' => '15000',
            'bank_name' => 'Mega Bank',
            'bank_account_number' => Str::random(12),
            'bank_branch_name' => 'Baneshwor',
            'status' => 1,
        ];
    }
}
