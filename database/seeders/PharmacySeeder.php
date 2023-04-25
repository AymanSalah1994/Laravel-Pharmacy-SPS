<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PharmacySeeder extends Seeder
{
    public function run(): void
    {
        Pharmacy::factory(10)->create()->each(function ($eachPharmacy) {
            $userPharmacy  = new User();
            $userPharmacy->assignRole('pharmacy');
            $userPharmacy->name = fake()->name();
            $userPharmacy->email = fake()->unique()->safeEmail();
            $userPharmacy->password = Hash::make('123456');
            $eachPharmacy->users()->save($userPharmacy);
        });
    }
}
