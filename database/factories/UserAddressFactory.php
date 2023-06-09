<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'area_id' => Area::pluck('id')->random(),
            'customer_id' => Customer::pluck('id')->random(),
            // TODO Only ID Of Type User Customer Not any User 
            // PLuck From User Model Not Customer , FK is From Users Model
            'street_name' => $this->faker->streetName(),
            'building_number' => $this->faker->numberBetween(1, 10),
            'floor_number' => $this->faker->numberBetween(1, 7),
            'flat_number' => $this->faker->numberBetween(1, 5),
            'is_main' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
