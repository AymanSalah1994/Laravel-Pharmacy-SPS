<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderMedicine>
 */
class OrderMedicineFactory extends Factory
{
    public function definition(): array
    {
        $types = ['Capsule', 'Drink'];
        return [
            'type' => $this->faker->randomElement($types),
            'medicine_id' => Medicine::pluck('id')->random(),
            'order_id' => Order::pluck('id')->random(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
