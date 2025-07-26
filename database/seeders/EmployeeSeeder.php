<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'user_id' => 2,
                'identity_card_id' => 2,
                'card' => 31049827,
                'gender_id' => 2,
                'name' => 'Yaneri',
                'lastname' => 'Perdomo',
                'telephone_number' => '+58239293',
                'address' => 'Sierra Maestra',
                'slug' => '31032823-yaneri-perdomo'
            ]
        ]);
    }
}
