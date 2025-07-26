<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                "identity_card_id" => 1,
                "gender_id" => 2,
                "name" => "Yaneri",
                "lastname" => "Perdomo",
                "card" => 31048726,
                "phone" => null,
                "address" => "Sierra Maestra",
                "slug" => "yaneri-perdomo-31048726"
            ],
            [
                "identity_card_id" => 1,
                "gender_id" => 2,
                "name" => "Glisdaly",
                "lastname" => "Barrios",
                "card" => 14237797,
                "phone" => null,
                "address" => "Cuidad Lossada, al frente de una cañada gigante",
                "slug" => "glisdaly-barrios-14237797"
            ]
        ]);
    }
}
