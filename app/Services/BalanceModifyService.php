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
        // 更新を実行(Updateメソッドで行っているので、変更がなくても更新日時が更新される)
        Balance::where('balance_id', session('balance_id'))->update([
                'storage_fee' => is_null($storage_fee) ? 0 : $storage_fee,
                'storage_expenses' => is_null($storage_expenses) ? 0 : $storage_expenses,
                'sales' => $total_sales,
                'expenses' => $total_expenses,
                'profit' => $total_profit,
                'balance_note' => $balance_note,
                'last_updated_user_id' => Auth::user()->id,
        ]);
    }
}