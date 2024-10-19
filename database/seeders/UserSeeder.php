<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'full_name' => 'admin',
            'email' => 'admin@brighton.academy.com',
            'password' => Hash::make('11111111'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
