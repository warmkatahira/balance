<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoHandlingCustomer extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'cargo_handling_customer_id';
    // 関連テーブル名を変更
    protected $table = 'cargo_handling_customer';

    Public function cargo_handling()
    {
        // cargo_handlingモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\CargoHandling', 'cargo_handling_id');
    }
}
