<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        $genders = ['male', 'female'];
        return [
            'gender' => $this->faker->randomElement($genders),
            'dob' => $this->faker->date(),
            'national_id' => $this->faker->uuid(),
            'profile_image' => '1.jpg', // Default Avatar Image
            'mobile_number' => $this->faker->phoneNumber(),
            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
