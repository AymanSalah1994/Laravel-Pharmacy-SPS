<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gender' => "Famale",
            // $this->faker->randomElements(['male', 'female']) NOT WORKING 
            'dob' => $this->faker->date(),
            'national_id' => $this->faker->uuid(),
            'profile_image' => '1.jpg', // Default Avatar Image 
            'mobile_number' => $this->faker->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
