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
            'shipping_company' => '佐川急便',
            'shipping_method' => '宅配便',
        ]);
        ShippingMethod::create([
            'shipping_method_id' => 2,
            'shipping_company' => 'ヤマト運輸',
            'shipping_method' => 'ネコポス',
        ]);
        ShippingMethod::create([
            'shipping_method_id' => 3,
            'shipping_company' => 'ヤマト運輸',
            'shipping_method' => '宅配便',
        ]);
        ShippingMethod::create([
            'shipping_method_id' => 4,
            'shipping_company' => '福山通運',
            'shipping_method' => '宅配便',
        ]);
        
    }
}
