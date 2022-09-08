<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplete extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'message_templete_id';
    // 挿入を許可する
    protected $fillable = [
        'templete_name', 'templete_title', 'templete_content',
    ];
}
