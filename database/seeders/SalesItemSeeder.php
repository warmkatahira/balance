<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalesItem;

class SalesItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesItem::create([
            'sales_item_id' => 1,
            'sales_item_name' => 'チャーター',
            'sales_item_note' => '',
        ]);
        SalesItem::create([
            'sales_item_id' => 2,
            'sales_item_name' => '資材購入',
            'sales_item_note' => '',
        ]);
    }
}
