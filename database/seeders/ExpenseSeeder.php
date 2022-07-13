<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expense::create([
            'expense_id' => 1,
            'expense_name' => '本社管理費',
            'expense_note' => '',
            'expense_category' => '毎月',
        ]);
        Expense::create([
            'expense_id' => 2,
            'expense_name' => 'セコム',
            'expense_note' => '',
            'expense_category' => '毎月',
        ]);
        Expense::create([
            'expense_id' => 3,
            'expense_name' => '経費A',
            'expense_note' => '',
            'expense_category' => '変動',
        ]);
        Expense::create([
            'expense_id' => 4,
            'expense_name' => '駐車場代',
            'expense_note' => '',
            'expense_category' => '毎月',
        ]);
        Expense::create([
            'expense_id' => 5,
            'expense_name' => 'コピー機',
            'expense_note' => '',
            'expense_category' => '毎月',
        ]);
    }
}
