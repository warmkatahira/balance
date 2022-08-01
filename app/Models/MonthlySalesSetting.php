<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySalesSetting extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'monthly_sales_setting_id';

    Public function sales_item()
    {
        // Salesモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\SalesItem', 'sales_item_id');
    }
}
