<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("payment_types")->insert([

            
            [
                "name" => "Tarjeta d/Credito",
            ],
            [
                "name" => "Tarjeta d/Debito",
            ],
            [
                "name" => "Efectivo en Bolivares",
            ],
            [
                "name" => "Efectivo en Divisas",
            ],
            [
                "name" => "Cheque",
            ],
            [
                "name" => "Transferencia",
            ],
            [
                "name" => "Mixto (Combinación de métodos)"
            ]
        ]);
    }
}
