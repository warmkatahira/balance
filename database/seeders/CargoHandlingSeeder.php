<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CargoHandling;

class CargoHandlingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoHandling::create([
            'cargo_handling_id' => 1,
            'cargo_handling_name' => '入庫（バラ）',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 2,
            'cargo_handling_name' => '入庫（ケース）',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 3,
            'cargo_handling_name' => '入庫（パレット）',
        ]);
    }
}
