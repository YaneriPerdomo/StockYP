<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("brands")->insert([
            [
                "name" => "SKF",
                "slug" => 'skf'
            ],
            [
                "name" => "NGK",
                "slug" => "ngk"
            ]
        ]);
    }
}
