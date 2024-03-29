<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CargoHandling;

class Customer extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'customer_id';

    Public function user()
    {
        // Userモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\User', 'register_user_id');
    }

    Public function base()
    {
        // Baseモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\Base', 'control_base_id');
    }

    public function shipping_methods(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\ShippingMethod', 'customer_shipping_method', 'customer_id', 'shipping_method_id')
                    ->withPivot('fare_unit_price', 'fare_expense', 'shipping_method_note')
                    ->withTimestamps();
    }
}
