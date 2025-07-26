<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_data')->insert([
            [
                "name" => "Accesorios y Repuestos",
                "address" => "Sierra Maestra, Calle 10, entre av. 10 y 11, #10-61 Diagonal al Vivero Girasol, Maracaibo, Venezuela"
            ]
        ]);
    }
}
