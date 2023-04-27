<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::factory(20)->create()->each(function ($eachDoctor) {
            $userDoctor  = new User();
            $userDoctor->assignRole('doctor');
            $userDoctor->name = fake()->name();
            $userDoctor->email = fake()->unique()->safeEmail();
            $userDoctor->password = Hash::make('123456');
            $eachDoctor->users()->save($userDoctor);
        });
    }
}
