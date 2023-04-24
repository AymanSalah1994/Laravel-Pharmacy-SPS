<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public static  function createReturnDoctor()
    {
        $doctor = new Doctor();
        $doctor->national_id  = "457568345";
        $doctor->avatar_image = "1.jpg";
        $doctor->created_at  = now();
        $doctor->updated_at  = now();
        $doctor->save();
        return $doctor;
    }
    public function run(): void
    {
        //
        $newDoctor = $this::createReturnDoctor();
        $userDoctor  = new User();
        $userDoctor->assignRole('doctor');
        // $userDoctor->name = "Doctor";
        // $userDoctor->email = "doctor@doctor.com";
        $userDoctor->name = fake()->name();
        $userDoctor->email = fake()->unique()->safeEmail();
        $userDoctor->password = Hash::make('123456');
        $newDoctor->users()->save($userDoctor);
    }
}
