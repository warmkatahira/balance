<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingMethod::create([
            'shipping_method_id' => 1,
            'shipping_method_name' => '佐川急便',
            'fare_unit_price' => 450,
            'fare_expenses' => 400,
        ]);
        ShippingMethod::create([
            'shipping_method_id' => 2,
            'shipping_method_name' => 'ヤマトネコポス',
            'fare_unit_price' => 190,
            'fare_expenses' => 160,
        ]);
        ShippingMethod::create([
            'shipping_method_id' => 3,
            'shipping_method_name' => 'ヤマト宅配',
            'fare_unit_price' => 500,
            'fare_expenses' => 450,
        ]);
    }
}
