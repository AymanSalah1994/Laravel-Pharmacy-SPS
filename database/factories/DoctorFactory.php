<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'national_id' => $this->faker->uuid(),
            'avatar_image' => '1.jpg', // Default Avatar Image
            'pharmacy_id' => Pharmacy::pluck('id')->random(),
            'is_banned' => $this->faker->boolean()  , 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
