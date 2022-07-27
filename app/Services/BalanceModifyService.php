<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Balance;
use App\Models\BalanceFare;
use App\Models\BalanceCargoHandling;
use App\Models\BalanceLaborCost;
use App\Models\BalanceOtherExpense;
use App\Models\BalanceOtherSale;
use Carbon\Carbon;

class BalanceModifyService
{
    // 収支テーブルを更新
    public function updateBalance($storage_fee, $storage_expenses, $balance_note, $total_sales, $total_expenses, $total_profit)
    {
        // 更新対象を取得
        $balance = Balance::find(session('balance_id'));
        $balance->storage_fee = is_null($storage_fee) ? 0 : $storage_fee;
        $balance->storage_expenses = is_null($storage_expenses) ? 0 : $storage_expenses;
        $balance->sales = $total_sales;
        $balance->expenses = $total_expenses;
        $balance->profit = $total_profit;
        $balance->balance_note = $balance_note;
        $balance->last_updated_user_id = Auth::user()->id;
        $balance->save();
    }
}