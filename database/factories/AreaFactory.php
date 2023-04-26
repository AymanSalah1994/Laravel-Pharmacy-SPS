<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => '818', //Egypt Cairo ID 
            'name' => $this->faker->city(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
