<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class, //1 
            AdminSeeder::class, // 2 
            PharmacySeeder::class, //3 
            DoctorSeeder::class, // 4 
            CustomerSeeder::class, // 4 
            MedicineSeeder::class, // 5
            CountriesSeeder::class, // 6 
            AreaSeeder::class, // 7
            UserAddressSeeder::class, // 8 
            OrderSeeder::class, // 9 
            OrderMedicineSeeder::class, // 10 
        ]);
        $this->command->info('Seeded All Data!');
    }
}
