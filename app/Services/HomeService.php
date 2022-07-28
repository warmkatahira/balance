<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Base;
use App\Models\Balance;
use App\Models\MonthlyExpensesSetting;
use App\Models\SalesPlan;

class HomeService
{
    public function getBase()
    {
        // 拠点の情報を取得
        $bases = Base::all();
        return $bases;
    }

    public function formatTargetDate($date)
    {
        // フォーマットしてセッションに格納
        session(['nowDateYearMonth' => $date->format('Y-m')]);
        return;
    }

    public function getResult($base_id, $MonthStartEndDate)
    {
        // 自拠点の荷主別の今月の成績を集計
        $query = Balance::query();
        $query = $query->where('balance_base_id', $base_id);
        $query = $query->whereBetween('balance_date', [$MonthStartEndDate['date_start_of_month'] , $MonthStartEndDate['date_end_of_month']]);
        $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_customer_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        $customer_results = $query->groupBy('balance_base_id', 'balance_customer_id', 'date')->orderBy('total_sales', 'desc')->get();
        // 自拠点の売上/経費/利益の今月の成績を集計
        $query = Balance::query();
        $query = $query->where('balance_base_id', $base_id);
        $query = $query->whereBetween('balance_date', [$MonthStartEndDate['date_start_of_month'] , $MonthStartEndDate['date_end_of_month']]);
        $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        $base_result = $query->groupBy('balance_base_id', 'date')->first();
        return with([
            'customer_results' => $customer_results,
            'base_result' => $base_result,
        ]);
    }

    public function getMonthlyExpenses($base_id, $date)
    {
        // 月額経費を集計
        $monthly_expenses = MonthlyExpensesSetting::where('base_id', $base_id)
                            ->where('setting_date', $date)
                            ->orderBy('expenses_amount', 'desc')
                            ->get();
        // 月額経費の合計を取得
        $total_monthly_expenses_amount = $monthly_expenses->sum('expenses_amount');
        return with([
            'monthly_expenses' => $monthly_expenses,
            'total_monthly_expenses_amount' => $total_monthly_expenses_amount,
        ]);
    }

    public function getSalesPlan($base_id, $date)
    {
        // 売上計画を集計
        $sales_plan = SalesPlan::where('base_id', $base_id)
                            ->where('plan_date', $date)
                            ->first();
        return $sales_plan;
    }

    public function inputSessionChartData($expenses, $result, $sales_plan)
    {
        // チャート表示に使用する条件をセッションに格納（チャート表示のAJAX通信で使用）
        session(['total_monthly_expenses_amount' => $expenses['total_monthly_expenses_amount']]);
        session(['total_profit' => is_null($result['base_result']) == true ? 0 : $result['base_result']['total_profit']]);
        session(['total_sales' => is_null($result['base_result']) == true ? 0 : $result['base_result']['total_sales']]);
        session(['sales_plan_amount' => is_null($sales_plan) == true ? 0 :$sales_plan->sales_plan_amount]);
        return;
    }

    public function getBalanceUpdateList()
    {
        // 収支の更新日時の降順10件を取得
        $balance_lists = Balance::orderBy('updated_at', 'desc')
                                ->take(10)->get();
        return $balance_lists;
    }
}