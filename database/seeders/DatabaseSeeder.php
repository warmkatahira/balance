<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            BaseSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            ShippingMethodSeeder::class,
            CargoHandlingSeeder::class,
            ExpensesItemSeeder::class,
            LaborCostSeeder::class,
            SalesItemSeeder::class,
        ]);
    }
}
