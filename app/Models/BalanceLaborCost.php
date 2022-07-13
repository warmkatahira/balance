<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceLaborCost extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'balance_labor_costs_id';
}
