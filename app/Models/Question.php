<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'question_id';
    // 挿入を許可する
    protected $fillable = [
        'question_title', 'answer_content',
    ];
}
