<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class BalanceAuthorityCheckService
{
    public function checkOperationAuthority($balance)
    {
        // 指定した収支がなかった場合
        if(empty($balance)){
            // エラーを返す
            return with([
                'result' => 1,
                'message' => '収支が存在しませんでした。'
            ]);
        }
        // 操作可能な権限（ユーザー）か確認
        if($balance->register_user_id != Auth::user()->id && Auth::user()->role_id != 1 && Auth::user()->role_id != 11 && Auth::user()->base_id != $balance->balance_base_id){
            // エラーを返す
            return with([
                'result' => 1,
                'message' => '権限がありません。'
            ]);
        }
        return with([
            'result' => 0,
            'message' => ''
        ]);
    }
}