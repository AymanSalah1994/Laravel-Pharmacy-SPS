<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        
        DB::table('users')->insert($adminArray);
        // BUG: Catching the Exception and Showing Nice Message  ; 
    }
}