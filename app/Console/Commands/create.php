<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class create extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $signature = "create:admin {--email=} {--password=}";

    protected $description = 'Create a New Admin With Email and Password';

    public function handle()
    {
        $adminArray = [
            'name'       => 'Admin',
            'email'      => $this->option('email'),
            'password'   => Hash::make($this->option('password')),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        try {
            // Validate that the email is unique
            $this->validate([
                'email' => ['required', 'email', 'unique:users,email'],
            ]);

            DB::table('users')->insert($adminArray);
            $this->info('Admin created successfully!');
        } catch (ValidationException $e) {
            $this->error('The email address must be unique.');
        }
    }
}
