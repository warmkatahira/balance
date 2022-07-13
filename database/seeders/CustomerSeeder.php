<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'customer_id' => 1,
            'customer_name' => '株式会社テスト',
            'control_base_id' => 1,
            'register_user_id' => 1,
            'monthly_storage_fee' => 35000,
            'working_days' => 20,
            'handling_fee_category' => '出荷個数',
        ]);
        Customer::create([
            'customer_id' => 2,
            'customer_name' => '株式会社intervia',
            'control_base_id' => 1,
            'register_user_id' => 2,
            'monthly_storage_fee' => 50000,
            'working_days' => 20,
            'handling_fee_category' => 'パーセンテージ',
        ]);
        Customer::create([
            'customer_id' => 3,
            'customer_name' => '株式会社徳昇商事',
            'control_base_id' => 3,
            'register_user_id' => 1,
            'monthly_storage_fee' => 12000,
            'working_days' => 20,
            'handling_fee_category' => '出荷個数',
        ]);
    }
}
