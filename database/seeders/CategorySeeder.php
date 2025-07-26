<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("categorys")->insert([
            [
                "name" => "Rodamientos",
                "slug" => "rodamientos"
            ]
        ]);
    }
}
