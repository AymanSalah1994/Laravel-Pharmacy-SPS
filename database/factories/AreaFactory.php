<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webpatser\Countries\Countries;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
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
