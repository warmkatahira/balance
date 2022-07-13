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
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 2,
            'cargo_handling_name' => '入庫（ケース）',
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 3,
            'cargo_handling_name' => '入庫（パレット）',
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 4,
            'cargo_handling_name' => '出荷（バラ）',
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 5,
            'cargo_handling_name' => '出荷（ケース）',
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 6,
            'cargo_handling_name' => '梱包',
            'cargo_handling_note' => '',
        ]);
        CargoHandling::create([
            'cargo_handling_id' => 7,
            'cargo_handling_name' => 'セット作業',
            'cargo_handling_note' => '',
        ]);
    }
}
