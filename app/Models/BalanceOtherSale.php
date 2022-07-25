<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceOtherSale extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'balance_other_sales_id';
}
