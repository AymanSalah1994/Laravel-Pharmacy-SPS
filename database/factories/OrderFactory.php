<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    public function definition(): array
    {
        $fixedCustomerID = Customer::pluck('id')->random();
        $stats = ['New', 'Processing', 'WaitingForUserConfirmation', 'Canceled', 'Confirmed', 'Delivered'];
        return [
            'user_id' => User::pluck('id')->random(),
            'customer_id' => $fixedCustomerID,
            'delivering_address_id' => UserAddress::where('id', $fixedCustomerID)->pluck('id')->random(),
            'is_insured' => $this->faker->boolean(),
            'status' => $this->faker->randomElement($stats),
            'total_price' => $this->faker->numberBetween(100, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
