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

            // Admin

            [
                'name' =>'Admin',
                'email' =>'admin@gmail.com',
                'password' => Hash::make('111'),
                'shop_name' =>'admin shop',
                'role' =>'Admin',
                'created_at' => '2024-12-07 03:51:48',
            ],

            // Merchant

            [
                'name' =>'Merchant',
                'email' =>'merchant@gmail.com',
                'password' => Hash::make('111'),
                'shop_name' =>'merchant shop',
                'role' =>'Merchant',
                'created_at' => '2024-12-07 03:51:48',
            ],

        ]);
    }
}
