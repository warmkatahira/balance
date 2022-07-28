<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Base;
use App\Models\Balance;
use App\Models\BalanceFare;
use App\Models\BalanceCargoHandling;
use App\Models\BalanceLaborCost;
use App\Models\BalanceOtherExpense;
use App\Models\BalanceOtherSale;
use Carbon\Carbon;

use App\Services\BalanceListService;

class BalanceListController extends Controller
{
    public function index()
    {
        // セッションの中身を削除
        session()->forget(['search_category', 'base_select', 'customer_select', 'date_category', 'date_period_from', 'date_period_to']);
        // 日付期間の初期値に今日の日付を設定
        $now_date = new Carbon('now');
        session(['date_period_from' => $now_date->format('Y-m-d')]);
        session(['date_period_to' => $now_date->format('Y-m-d')]);
        // 荷主情報を取得
        $customers = Customer::all();
        $bases = Base::all();
        $balances = array();
        return view('balance_list.index')->with([
            'customers' => $customers,
            'bases' => $bases,
            'balances' => $balances,
        ]);
    }

    public function search(Request $request)
    {
        // 現在のURLを取得
        session(['index_url' => url()->full()]);
        $BalanceListService = new BalanceListService;
        // リクエストパラメータを取得
        $req_param = $BalanceListService->getRequestParameter($request);
        // セッションに検索条件を格納
        $BalanceListService->inputSearchInfoToSession($req_param);
        // 日付期間の開始と終了を取得
        $BalanceListService->getStartEndOfDate(session('date_period_from'), session('date_period_to'));
        // 収支を取得
        $balances = $BalanceListService->getBalances();
        // 荷主情報を取得
        $customers = $BalanceListService->getCustomers(session('base_select'));
        $bases = Base::all();
        return view('balance_list.index')->with([
            'customers' => $customers,
            'bases' => $bases,
            'balances' => $balances,
        ]);
    }

    public function index_zensha(Request $request)
    {
        $BalanceListService = new BalanceListService;
        // 日付期間の開始と終了を取得
        $BalanceListService->getStartEndOfDate($request->date, $request->date);
        $balances = $BalanceListService->getBalanceToZenshaDetail();
        return view('balance_list.index_zensha')->with([
            'balances' => $balances,
        ]);
    }

    public function index_base(Request $request)
    {
        $BalanceListService = new BalanceListService;
        // 日付期間の開始と終了を取得
        $BalanceListService->getStartEndOfDate($request->date, $request->date);
        $balances = $BalanceListService->getBalanceToBaseDetail($request->base_id);
        return view('balance_list.index_base')->with([
            'balances' => $balances,
        ]);
    }

    public function index_customer(Request $request)
    {
        // セッションに情報を格納(AJAXで使用)
        session(['customer_id' => $request->customer_id]);
        session(['date' => $request->date]);
        // サービスクラスを定義
        $BalanceListService = new BalanceListService;
        // 日付期間の開始と終了を取得
        $BalanceListService->getStartEndOfDate($request->date, $request->date);
        $balances = $BalanceListService->getBalanceToCustomerDetail($request->base_id, $request->customer_id);
        session(['balances' => $balances]);
        // 荷主情報を取得
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        return view('balance_list.index_customer')->with([
            'balances' => $balances,
            'customer' => $customer,
        ]);
    }

    public function detail(Request $request)
    {
        session(['previous_url' => url()->previous()]);
        session(['balance_id' => $request->balance_id]);
        $balance = Balance::where('balance_id', $request->balance_id)->first();
        $balance_fare_sales = BalanceFare::where('balance_id', $request->balance_id)->where('fare_balance_category', 'sales')->get();
        $balance_cargo_handlings = BalanceCargoHandling::where('balance_id', $request->balance_id)->get();
        $balance_fare_expenses = BalanceFare::where('balance_id', $request->balance_id)->where('fare_balance_category', 'expenses')->get();
        $balance_labor_costs = BalanceLaborCost::where('balance_id', $request->balance_id)->get();
        $balance_other_expenses = BalanceOtherExpense::where('balance_id', $request->balance_id)->get();
        $balance_other_sales = BalanceOtherSale::where('balance_id', $request->balance_id)->get();
        // サービスクラスを定義
        $BalanceListService = new BalanceListService;
        // 各項目の合計を取得
        $total_amount = $BalanceListService->getTotalAmount($balance_fare_sales, $balance_cargo_handlings, $balance_fare_expenses, $balance_labor_costs, $balance_other_expenses, $balance_other_sales);
        return view('balance_list.detail')->with([
            'balance' => $balance,
            'balance_fare_sales' => $balance_fare_sales,
            'balance_cargo_handlings' => $balance_cargo_handlings,
            'balance_fare_expenses' => $balance_fare_expenses,
            'balance_labor_costs' => $balance_labor_costs,
            'balance_other_expenses' => $balance_other_expenses,
            'balance_other_sales' => $balance_other_sales,
            'total_amount' => $total_amount,
        ]);
    }

    public function balance_detail_get_ajax(Request $request)
    {
        // 収支情報を取得
        $balance = Balance::where('balance_id', $request->balance_id)->first();
        // チャートに使用する合計金額を取得
        $cargo_handling_sum = BalanceCargoHandling::where('balance_id', $request->balance_id)->sum('cargo_handling_amount');
        $fare_sales_sum = BalanceFare::where('balance_id', $request->balance_id)->where('fare_balance_category', 'sales')->sum('fare_amount');
        $labor_costs_sum = BalanceLaborCost::where('balance_id', $request->balance_id)->sum('labor_costs');
        $fare_expenses_sum = BalanceFare::where('balance_id', $request->balance_id)->where('fare_balance_category', 'expenses')->sum('fare_amount');
        $other_expenses_amount_sum = BalanceOtherExpense::where('balance_id', $request->balance_id)->sum('other_expenses_amount');
        $other_sales_amount_sum = BalanceOtherSale::where('balance_id', $request->balance_id)->sum('other_sales_amount');
        // 結果を返す
        return response()->json([
            'balance' => $balance,
            'cargo_handling_sum' => $cargo_handling_sum,
            'fare_sales_sum' => $fare_sales_sum,
            'labor_costs_sum' => $labor_costs_sum,
            'fare_expenses_sum' => $fare_expenses_sum,
            'other_expenses_amount_sum' => $other_expenses_amount_sum,
            'other_sales_amount_sum' => $other_sales_amount_sum,
        ]);
    }

    public function get_customer_ajax(Request $request)
    {
        $BalanceListService = new BalanceListService;
        // 選択された拠点の荷主を取得
        $customers = $BalanceListService->getCustomers($request->base_id);
        // 結果を返す
        return response()->json([
            'customers' => $customers,
        ]);
    }

    public function index_customer_get_ajax(Request $request)
    {
        // 配列用の変数をセット
        $date = [];
        $sales = [];
        $expenses = [];
        $profit = [];
        foreach(session('balances') as $balance){
            // 収支日をフォーマット
            $date_format = new Carbon($balance->date);
            // それぞれの値を配列に追加
            array_push($date, $date_format->format('m月d日'));
            array_push($sales, $balance->total_sales);
            array_push($expenses, $balance->total_expenses);
            array_push($profit, $balance->total_profit);
        }
        // 結果を返す
        return response()->json([
            'date' => $date,
            'sales' => $sales,
            'expenses' => $expenses,
            'profit' => $profit,
        ]);
    }
}
