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
            // $this->faker->randomElements(['male', 'female']) NOT WORKING
            'gender' =>  $this->faker->title($gender = 'male'|'female') ,
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
