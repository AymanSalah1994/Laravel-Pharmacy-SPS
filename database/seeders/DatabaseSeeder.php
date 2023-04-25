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
            // RolesSeeder::class, //1 
            // AdminSeeder::class, // 2 
            // PharmacySeeder::class, //3 
            // DoctorSeeder::class, // 4 
            CountriesSeeder::class, // 4 
        ]);
        // $this->call('CountriesSeeder');
        $this->command->info('Seeded the countries!');
    }
}
