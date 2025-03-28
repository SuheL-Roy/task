<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Manager',
                'created_at' => now(), // Using Laravel's helper function for the current timestamp
                'updated_at' => now(), // Add updated_at to maintain consistency
            ],
        ]);
    }
}
