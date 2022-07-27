<?php

namespace App\Services;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Balance;
use App\Models\Customer;
use Carbon\Carbon;

class BalanceListService
{
    public function getCustomers($base_id)
    {
        // クエリを使用する
        $query = Customer::query();
        // 全拠点かそれ以外かによって処理を分岐
        if($base_id == '全拠点'){
            $customers = $query->get();
        }
        if($base_id != '全拠点'){
            $customers = $query->where('control_base_id', $base_id)->get();
        }
        return $customers;
    }

    public function getRequestParameter($request)
    {
        // リクエストパラメータを取得
        $req_param = $request->only([
            'search_category_select',
            'base_select',
            'customer_select',
            'date_category_select',
            'date_period_from',
            'date_period_to',
        ]);
        return $req_param;
    }

    public function inputSearchInfoToSession($req_param)
    {
        // セッションに検索条件を格納
        session(['search_category' => $req_param['search_category_select']]);
        session(['date_category' => $req_param['date_category_select']]);
        session(['date_period_from' => $req_param['date_period_from']]);
        session(['date_period_to' => $req_param['date_period_to']]);
        if(!empty($req_param['base_select'])){
            session(['base_select' => $req_param['base_select']]);
        }
        if(!empty($req_param['customer_select'])){
            session(['customer_select' => $req_param['customer_select']]);
        }
    }

    public function getStartEndOfDate($date_period_from, $date_period_to)
    {
        // 日付区分が「日別」の場合、リクエストの値を格納
        if(session('date_category') == '日別'){
            session(['date_search_from' => $date_period_from]);
            session(['date_search_to' => $date_period_to]);
        }
        // 日付区分が「月別」の場合、月初・月末の日付を取得・格納
        if(session('date_category') == '月別'){
            // 「date_period_from」から月初の日付を取得
            $date_period_start_of_month = new Carbon($date_period_from);
            $date_period_start_of_month = $date_period_start_of_month->startOfMonth()->format('Y-m-d');
            // 「date_period_to」から月末の日付を取得
            $date_period_end_of_month = new Carbon($date_period_to);
            $date_period_end_of_month = $date_period_end_of_month->endOfMonth()->format('Y-m-d');
            session(['date_search_from' => $date_period_start_of_month]);
            session(['date_search_to' => $date_period_end_of_month]);
        }
        return;
    }

    public function getBalances()
    {
        // 検索区分によって処理を分岐
        if(session('search_category') == '全社'){
            $balances = $this->getBalancesToZensha();
        }
        if(session('search_category') == '拠点'){
            $balances = $this->getBalancesToBase();
        }
        if(session('search_category') == '荷主'){
            $balances = $this->getBalancesToCustomer();
        }
        $balances = $balances->paginate(20);
        return $balances;
    }

    // 検索区分=全社
    public function getBalancesToZensha()
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from') , session('date_search_to')]);
        // 日別・月別で日付の選択を分岐
        if(session('date_category') == '日別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_date as date"));
        }
        if(session('date_category') == '月別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        }
        // グループ化・並び替え
        $balances = $query->groupBy('date')->orderBy('date', 'asc');
        return $balances;
    }

    // 検索区分=拠点
    public function getBalancesToBase()
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from') , session('date_search_to')]);
        // 拠点の指定
        if(session('base_select') != '全拠点'){
            $query = $query->where('balance_base_id', session('base_select'));   
        }
        // 日別・月別で日付の選択を分岐
        if(session('date_category') == '日別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_date as date"));
        }
        if(session('date_category') == '月別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        }
        // グループ化・並び替え
        $balances = $query->groupBy('balance_base_id', 'date')->orderBy('date', 'asc');
        return $balances;
    }

    // 検索区分=荷主
    public function getBalancesToCustomer()
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from') , session('date_search_to')]);
        // 拠点の指定
        if(session('base_select') != '全拠点'){
            $query = $query->where('balance_base_id', session('base_select'));
        }
        // 荷主の指定
        if(session('customer_select') != '全荷主'){
            $query = $query->where('balance_customer_id', session('customer_select'));
        }
        // 日別・月別で日付の選択を分岐
        if(session('date_category') == '日別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_id, register_user_id, balance_base_id, balance_customer_id, balance_date as date, created_at, updated_at"));
            // 並び替え
            $balances = $query->groupBy('balance_id', 'register_user_id', 'balance_base_id', 'balance_customer_id', 'date')->orderBy('date', 'asc');
        }
        if(session('date_category') == '月別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_customer_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
            // グループ化・並び替え
            $balances = $query->groupBy('balance_base_id', 'balance_customer_id', 'date')->orderBy('date', 'asc');
        }
        return $balances;
    }

    public function getBalanceToZenshaDetail()
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from'), session('date_search_to')]);
        // 日別・月別で日付の選択を分岐
        if(session('date_category') == '日別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_date as date"));
        }
        if(session('date_category') == '月別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        }
        // グループ化・並び替え
        $balances = $query->groupBy('balance_base_id', 'date')->orderBy('total_sales', 'desc')->get();
        return $balances;
    }

    public function getBalanceToBaseDetail($base_id)
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from'), session('date_search_to')]);
        // 拠点の指定
        if($base_id != '全拠点'){
            $query = $query->where('balance_base_id', $base_id);
        }
        // 日別・月別で日付の選択を分岐
        if(session('date_category') == '日別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_customer_id, balance_date as date"));
        }
        if(session('date_category') == '月別'){
            $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_base_id, balance_customer_id, DATE_FORMAT(balance_date, '%Y-%m') as date"));
        }
        // グループ化・並び替え
        $balances = $query->groupBy('balance_base_id', 'balance_customer_id', 'date')->orderBy('total_sales', 'desc')->get();
        return $balances;
    }

    public function getBalanceToCustomerDetail($base_id, $customer_id)
    {
        // クエリを使用する
        $query = Balance::query();
        // 収支日の期間抽出
        $query = $query->whereBetween('balance_date', [session('date_search_from'), session('date_search_to')]);
        // 拠点の指定
        if($base_id != '全拠点'){
            $query = $query->where('balance_base_id', $base_id);
        }
        // 荷主の指定
        if($customer_id != '全荷主'){
            $query = $query->where('balance_customer_id', $customer_id);
        }
        // 月別しか処理が入ってこないので処理は1つだけ
        $query = $query->select(DB::raw("sum(sales) as total_sales, sum(expenses) as total_expenses, sum(profit) as total_profit, balance_id, register_user_id, balance_base_id, balance_customer_id, balance_date as date"));
        // グループ化・並び替え
        $balances = $query->groupBy('balance_id', 'register_user_id', 'balance_base_id', 'balance_customer_id', 'date')->orderBy('date', 'desc')->get();
        return $balances;
    }

    public function getTotalAmount($balance_fare_sales, $balance_cargo_handlings, $balance_fare_expenses, $balance_labor_costs, $balance_other_expenses, $balance_other_sales)
    {
        // 各項目の合計を集計
        $total_fare_sales_amount = $balance_fare_sales->sum('fare_amount');
        $total_sales_box_quantity = $balance_fare_sales->sum('box_quantity');
        $total_cargo_handling_amount = $balance_cargo_handlings->sum('cargo_handling_amount');
        $total_operation_quantity = $balance_cargo_handlings->sum('operation_quantity');
        $total_fare_expenses_amount = $balance_fare_expenses->sum('fare_amount');
        $total_expenses_box_quantity = $balance_fare_expenses->sum('box_quantity');
        $total_labor_costs_amount = $balance_labor_costs->sum('labor_costs');
        $total_working_time = $balance_labor_costs->sum('working_time');
        $total_other_expenses_amount = $balance_other_expenses->sum('other_expenses_amount');
        $total_other_sales_amount = $balance_other_sales->sum('other_sales_amount');
        return with([
            'total_fare_sales_amount' => $total_fare_sales_amount,
            'total_sales_box_quantity' => $total_sales_box_quantity,
            'total_cargo_handling_amount' => $total_cargo_handling_amount,
            'total_operation_quantity' => $total_operation_quantity,
            'total_fare_expenses_amount' => $total_fare_expenses_amount,
            'total_expenses_box_quantity' => $total_expenses_box_quantity,
            'total_labor_costs_amount' => $total_labor_costs_amount,
            'total_working_time' => $total_working_time,
            'total_other_expenses_amount' => $total_other_expenses_amount,
            'total_other_sales_amount' => $total_other_sales_amount,
        ]);
    }
}