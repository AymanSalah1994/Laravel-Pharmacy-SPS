<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public static function createReturnAdmin()
    {
        $admin = new Admin();
        $admin->created_at  = now();
        $admin->updated_at  = now();
        $admin->save();
        return $admin;
    }

    public function run(): void
    {
        $newAdmin = $this::createReturnAdmin();
        $userAdmin  = new User();
        $userAdmin->assignRole('admin');
        $userAdmin->name = "Admin";
        $userAdmin->email = "admin@admin.com";
        $userAdmin->password = Hash::make('123456');
        $newAdmin->users()->save($userAdmin);
        // JUST One Admin So I will Leave it !!
    }
}
