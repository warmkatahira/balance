<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpensesItem;

class ExpensesItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpensesItem::create([
            'expenses_item_id' => 1,
            'expenses_item_name' => '本社管理費',
            'expenses_item_note' => '',
            'expenses_item_category' => '毎月',
        ]);
        ExpensesItem::create([
            'expenses_item_id' => 2,
            'expenses_item_name' => 'セコム',
            'expenses_item_note' => '',
            'expenses_item_category' => '毎月',
        ]);
        ExpensesItem::create([
            'expenses_item_id' => 3,
            'expenses_item_name' => '経費A',
            'expenses_item_note' => '',
            'expenses_item_category' => '変動',
        ]);
        ExpensesItem::create([
            'expenses_item_id' => 4,
            'expenses_item_name' => '駐車場代',
            'expenses_item_note' => '',
            'expenses_item_category' => '毎月',
        ]);
        ExpensesItem::create([
            'expenses_item_id' => 5,
            'expenses_item_name' => 'コピー機',
            'expenses_item_note' => '',
            'expenses_item_category' => '毎月',
        ]);
        ExpensesItem::create([
            'expenses_item_id' => 6,
            'expenses_item_name' => '物品購入',
            'expenses_item_note' => '',
            'expenses_item_category' => '変動',
        ]);
    }
}
