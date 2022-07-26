<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPlan extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'sales_plan_id';
}
