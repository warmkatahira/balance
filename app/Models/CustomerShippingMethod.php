<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerShippingMethod extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'customer_shipping_method_id';
    // 関連テーブル名を変更
    protected $table = 'customer_shipping_method';
}
