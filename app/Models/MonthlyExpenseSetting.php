<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyExpenseSetting extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'monthly_expense_setting_id';

    Public function expense()
    {
        // Expenseモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\Expense', 'expense_id');
    }
}
