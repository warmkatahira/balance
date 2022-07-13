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
    // 処理を許容するカラムを定義
    protected $fillable = ['cargo_handling_customer_id', 'customer_id', 'cargo_handling_id', 'cargo_handling_unit_price'];
}
