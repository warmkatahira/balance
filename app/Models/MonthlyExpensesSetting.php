<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyExpensesSetting extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'monthly_expenses_setting_id';

    Public function expenses_item()
    {
        // Expenseモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\ExpensesItem', 'expenses_item_id');
    }
}
