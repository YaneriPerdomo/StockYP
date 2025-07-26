<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("suppliers")->insert([
            [
                "gender_id" => 1,
                "name" => "Showis",
                "identity_card_id" => 1,
                "card" => "1234578",
                
                "telephone_number" => "58+948394",
                "address" => "Sierra Maestra, Calle 10, entre av. 10 y 11, #10-61 Diagonal al Vivero Girasol, Maracaibo, Venezuela",
                "slug" => "showis"
            ]
        ]);
    }
}
