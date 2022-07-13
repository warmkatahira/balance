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

    public function cargo_handlings(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\CargoHandling', 'cargo_handling_customer', 'customer_id', 'cargo_handling_id')
                    ->withPivot('cargo_handling_unit_price', 'balance_register_default_disp')
                    ->withTimestamps();
    }
}
