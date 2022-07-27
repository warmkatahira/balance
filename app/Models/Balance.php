<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Balance extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'balance_id';

    Public function user()
    {
        // Userモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\User', 'register_user_id');
    }

    Public function last_updated_user()
    {
        // Userモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\User', 'last_updated_user_id');
    }

    Public function base()
    {
        // Baseモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\Base', 'balance_base_id');
    }

    Public function customer()
    {
        // Customerモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\Customer', 'balance_customer_id');
    }
}
