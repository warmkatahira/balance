<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Base;
use App\Models\MonthlyExpenseSetting;

class BalanceListDailyController extends Controller
{
    public function index()
    {
        // 収支テーブルから拠点と収支日をグループ化して重複を除いた情報を取得
        $balances = Balance::select('balance_base_id', 'balance_date')
                    ->groupBy('balance_base_id', 'balance_date')
                    ->orderBy('balance_date', 'asc')
                    ->get();
        return view('balance_list_daily.index')->with([
            'balances' => $balances,
        ]);
    }

    public function detail(Request $request)
    {
        // 拠点と収支日で抽出して収支情報を取得
        $balances = Balance::where('balance_base_id', $request->base_id)
                    ->where('balance_date', $request->balance_date)
                    ->orderBy('sales', 'desc')
                    ->get();
        // 拠点の情報を取得
        $base = Base::where('base_id', $request->base_id)->first();
        // 各金額を集計
        $total_amount = Balance::where('balance_base_id', $request->base_id)
                        ->where('balance_date', $request->balance_date)
                        ->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit"))
                        ->first();
        // 月額経費を抽出する用に収支日をフォーマット（yyyymmの形式に）
        $balance_date_Ym = new Carbon($request->balance_date);
        $balance_date_Ym = $balance_date_Ym->format('Ym');
        // 収支日と同じ年月の拠点の月額経費を取得
        $monthly_expenses = MonthlyExpenseSetting::where('base_id', $request->base_id)
                            ->where('setting_date', $balance_date_Ym)
                            ->get();
        return view('balance_list_daily.detail')->with([
            'balances' => $balances,
            'balance_date' => $request->balance_date,
            'base' => $base,
            'total_amount' => $total_amount,
            'monthly_expenses' => $monthly_expenses,
        ]);
    }
}
