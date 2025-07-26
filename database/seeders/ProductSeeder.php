<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                "supplier_id" => 1,
                "category_id" => 1,
                "brand_id" => 1,
                "location_id" => 1,
                "name" => "Rodamientos de moto",
                "code" => "SD323",
                "price_dollar" => 5.4,
                "sale_profit_percentage" => 30,
                "discount_only_dollar" => 0,
                "stock_available" => 0,
                "description" => null,
                'state' => 'Para la venta',
                "slug_name" => "rodamientos-de-mato",
                "slug" => "rodamientos-de-mato-sd323"
            ]
        ]);
    }
}
