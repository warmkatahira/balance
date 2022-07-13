<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Customer;

class CargoHandling extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'cargo_handling_id';

    Public function customer()
    {
        // Customerモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Customer', 'cargo_handling_customer', 'cargo_handling_id', 'customer_id');
    }
}
