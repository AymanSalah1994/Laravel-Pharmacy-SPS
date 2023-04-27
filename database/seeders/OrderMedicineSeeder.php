<?php

namespace Database\Seeders;

use App\Models\OrderMedicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderMedicine::factory()->count(10)->create();
    }
}
