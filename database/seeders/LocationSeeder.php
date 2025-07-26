<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("locations")->insert([
            [
                "name" => "Estando numero 1",
                "slug" => "estante-numero-1"
            ],
            [
                "name" => "Estando numero 2",
                "slug" => "estante-numero-2"
            ],
            [
                "name" => "Estando numero 3",
                "slug" => "estante-numero-3"
            ]
        ]);
    }
}
