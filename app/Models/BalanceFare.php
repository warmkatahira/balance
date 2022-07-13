<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceFare extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'balance_fare_id';
}
