<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //  Make the Loop For a Number Of Time If you want
        $this->call([
            RolesSeeder::class,
            AdminSeeder::class,
            PharmacySeeder::class,
            DoctorSeeder::class,
        ]);
    }
}
