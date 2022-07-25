<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use Illuminate\Support\Facades\Auth;

use App\Services\BalanceAuthorityCheckService;

class BalanceDeleteController extends Controller
{
    public function delete(Request $request)
    {
        // サービスクラスを定義
        $BalanceAuthorityCheckService = new BalanceAuthorityCheckService;
        // 削除対象の収支を取得
        $balance = Balance::where('balance_id', $request->balance_id)->first();
        // 削除権限があるか確認
        $result = $BalanceAuthorityCheckService->checkOperationAuthority($balance);
        // エラーがあれば処理を終了
        if($result['result'] == 1){
            // エラーメッセージを表示
            session()->flash('alert_danger', $result['message']);
            return back();
        }
        // 削除を実施
        $balance->delete();
        session()->flash('alert_success', '削除が完了しました。');
        return back();
    }
}
