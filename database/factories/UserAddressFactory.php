<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'area_id' => Area::factory(),
            'customer_id' => Customer::factory(),
            'street_name' => fake()->name(),
            'building_number' => fake()->number_format(),
            'floor_number' => fake()->number_format(),
            'flat_number' => fake()->number_format(),
            'is_main' => fake()->boolean()
        ];
    }
}
