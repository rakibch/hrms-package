<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
         DB::table('users')->insertGetId([
            'user_name' => 'admin',
            'first_name' => 'Melvin',
            'last_name' => 'Armstrong',
            'email' => 'admin@softzino.com',
            'password' => Hash::make('Softzino'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
