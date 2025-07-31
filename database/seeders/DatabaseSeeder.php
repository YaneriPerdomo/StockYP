<?php

namespace Database\Seeders;

use App\Models\DollarRate;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PaymentTypesSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            LocationSeeder::class,
            DollarRateSeeder::class,
            GenderSeeder::class,
            IdentityCardSeeder::class,
            IvaSeeder::class,
            BusinessDataSeeder::class,
            CreditRateSeeder::class,
            SupplierSeeder::class,
            SavingSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            EmployeeSeeder::class
        ]);


    }
}
