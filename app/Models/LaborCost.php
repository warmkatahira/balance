<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborCost extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'labor_cost_id';
    // オートインクリメント無効化
    public $incrementing = false;
}
