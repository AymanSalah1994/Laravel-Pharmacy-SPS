<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory(10)->create()->each(function ($eachCustomer) {
            $userCustomer  = new User();
            $userCustomer->assignRole('user');
            $userCustomer->name = fake()->name();
            $userCustomer->email = fake()->unique()->safeEmail();
            $userCustomer->password = Hash::make('123456');
            $eachCustomer->users()->save($userCustomer);
        });
    }
}
