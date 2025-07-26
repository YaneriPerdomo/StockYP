<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentityCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("identity_cards")->insert(
            [
                [
                    'identity_card' => 'Venezolano cedulado',
                    'description' => 'Cédula de identidad para ciudadanos venezolanos.',
                    'letter' => 'V'
                ],
                [
                    'identity_card' => 'Extranjero cedulado',
                    'description' => 'Cédula de identidad para ciudadanos extranjeros residentes.',
                    'letter' => 'E'
                ],
                [
                    'identity_card' => ' Ciudadano no cedulado',
                    'description' => 'Identificador para un cuidadano que no tiene ningun documento legar.',
                    'letter' => null
                ],
                [
                    'identity_card' => 'Pasaporte cedulado',
                    'description' => 'Identificador para un cuidadano que no tiene ningun documento legar.',
                    'letter' => 'P'
                ],
                [
                    'identity_card' => 'Gobierno',
                    'description' => 'Identificador para un cuidadano que no tiene ningun documento legar.',
                    'letter' => 'G'
                ],
                [
                    'identity_card' => 'Jurídico',
                    'description' => 'Identificador para un cuidadano que no tiene ningun documento legar.',
                    'letter' => 'J'
                ],
            ]
        );
    }
}
