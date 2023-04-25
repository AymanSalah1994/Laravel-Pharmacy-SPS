<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{

    public function definition(): array
    {
        return [
            'national_id' => $this->faker->uuid(),
            'avatar_image' => '1.jpg', // Default Avatar Image
            'priority' => $this->faker->numberBetween(1,5), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
