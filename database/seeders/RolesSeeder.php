<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pharmacy']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'user']);
    }
}
