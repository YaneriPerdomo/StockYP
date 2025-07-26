<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                "user" => 'admin',
                "rol_id" => 1,
                "email" => "admin@gmail.com",
                'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                "user" => 'EspecialistaYaneri',
                "rol_id" => 2,
                "email" => "yaneriperdomopaolabarrios@gmail.com",
                'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

    }
}
