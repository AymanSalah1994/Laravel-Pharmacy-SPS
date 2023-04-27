<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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


        $data = array(
            'email' => $this->option('email'),
            'password'  => $this->option('password')
        );

        $rules = array(
            'email' => 'required|email|unique:users,email',
            'password'  => 'required',
        );

        $validator = Validator::make($data, $rules);


        if ($validator->fails()) {
            $this->error('Data is Not Valid.');
        } else {
            DB::table('users')->insert($adminArray);
            $this->info('Admin created successfully!');
        }
    }


    public function checkEmailExits()
    {
    }
}
