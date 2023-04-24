<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PharmacySeeder extends Seeder
{
    public static  function createReturnPharmacy()
    {
        $pharmacy = new Pharmacy();
        $pharmacy->national_id  = "23453456";
        $pharmacy->avatar_image = "1.jpg";
        $pharmacy->created_at  = now();
        $pharmacy->updated_at  = now();
        $pharmacy->save();
        return $pharmacy;
    }
    public function run(): void
    {
        $newPharmacy = $this::createReturnPharmacy();
        $userPharmacy  = new User();
        $userPharmacy->assignRole('pharmacy');
        // $userPharmacy->name = "Pharmacy";
        // $userPharmacy->email = "pharmacy@pharmacy.com";
        $userPharmacy->name = fake()->name();
        $userPharmacy->email = fake()->unique()->safeEmail();
        $userPharmacy->password = Hash::make('123456');
        $newPharmacy->users()->save($userPharmacy);
    }

}
