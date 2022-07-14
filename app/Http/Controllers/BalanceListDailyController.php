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
        $balances = Balance::select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_date, balance_base_id"))
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
        $balance_date = new Carbon($request->balance_date);
        $balance_date_Ym = $balance_date->format('Ym');
        // 収支月の月の日数を取得
        $days_in_month = $balance_date->daysInMonth;
        // 収支日と同じ年月の拠点の月額経費を取得
        $monthly_expenses = MonthlyExpenseSetting::where('base_id', $request->base_id)
                            ->where('setting_date', $balance_date_Ym)
                            ->select(DB::raw("ceil(expense_amount/$days_in_month) as daily_amount, expense_id, expense_amount"))
                            ->get();
        // 収支集計区分=日割の日割り経費合計を取得
        $total_daily_amount = 0;
        foreach($monthly_expenses as $monthly_expense){
            if($monthly_expense->expense->balance_aggregate_category == '日割'){
                $total_daily_amount += $monthly_expense->daily_amount;
            }
        }
        return view('balance_list_daily.detail')->with([
            'balances' => $balances,
            'balance_date' => $request->balance_date,
            'base' => $base,
            'total_amount' => $total_amount,
            'monthly_expenses' => $monthly_expenses,
            'total_daily_amount' => $total_daily_amount,
        ]);
    }
}
