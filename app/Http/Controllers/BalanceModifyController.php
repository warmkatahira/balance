<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\BalanceFare;
use App\Models\BalanceCargoHandling;
use App\Models\BalanceLaborCost;
use App\Models\BalanceOtherExpense;
use App\Models\BalanceOtherSale;
use App\Models\ExpensesItem;
use App\Models\SalesItem;
use App\Models\CargoHandlingCustomer;
use App\Models\CustomerShippingMethod;
use Carbon\Carbon;

use App\Services\BalanceRegisterService;
use App\Services\BalanceModifyService;
use App\Services\BalanceAuthorityCheckService;

class BalanceModifyController extends Controller
{
    public function index(Request $request)
    {
        // サービスクラスを定義
        $BalanceAuthorityCheckService = new BalanceAuthorityCheckService;
        // 収支情報を取得
        $balance = Balance::where('balance_id', $request->balance_id)->first();
        // 修正権限があるか確認
        $result = $BalanceAuthorityCheckService->checkOperationAuthority($balance);
        // エラーがあれば処理を終了
        if($result['result'] == 1){
            // エラーメッセージを表示
            session()->flash('alert_danger', $result['message']);
            return back();
        }
        // セッションに収支IDを格納
        session(['balance_id' => $request->balance_id]);
        // 修正対象の収支情報を取得
        $balance_fares = BalanceFare::where('balance_id', $request->balance_id)->get();
        $balance_cargo_handlings = BalanceCargoHandling::where('balance_id', $request->balance_id)->get();
        $balance_labor_costs = BalanceLaborCost::where('balance_id', $request->balance_id)->get();
        $balance_other_expenses = BalanceOtherExpense::where('balance_id', $request->balance_id)->get();
        $balance_other_sales = BalanceOtherSale::where('balance_id', $request->balance_id)->get();
        // 荷主IDで荷役設定を取得
        $cargo_handlings = CargoHandlingCustomer::where('customer_id', $balance->balance_customer_id)
                            ->join('cargo_handlings', 'cargo_handling_customer.cargo_handling_id', '=', 'cargo_handlings.cargo_handling_id')
                            ->select('cargo_handling_customer.*', 'cargo_handlings.cargo_handling_name')
                            ->get();
        // 荷主IDで配送方法設定を取得
        $shipping_methods = CustomerShippingMethod::where('customer_id', $balance->balance_customer_id)
                            ->join('shipping_methods', 'customer_shipping_method.shipping_method_id', '=', 'shipping_methods.shipping_method_id')
                            ->select('customer_shipping_method.*', 'shipping_methods.*')
                            ->get();
        // マスタの情報を取得
        $expenses_items = ExpensesItem::where('expenses_item_category', '変動')->get();
        $sales_items = SalesItem::all();
        return view('balance_modify.index')->with([
            'balance' => $balance,
            'balance_fares' => $balance_fares,
            'balance_cargo_handlings' => $balance_cargo_handlings,
            'balance_labor_costs' => $balance_labor_costs,
            'balance_other_expenses' => $balance_other_expenses,
            'balance_other_sales' => $balance_other_sales,
            'expenses_items' => $expenses_items,
            'sales_items' => $sales_items,
            'cargo_handlings' => $cargo_handlings,
            'shipping_methods' => $shipping_methods,
        ]);
    }

    public function modify(Request $request)
    {
        // サービスクラスを定義
        $BalanceRegisterService = new BalanceRegisterService;
        $BalanceModifyService = new BalanceModifyService;
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // リクエストパラメータを取得
        $req_param = $BalanceRegisterService->getRequestParameter($request);
        // トランザクションで更新処理を実施
        DB::transaction(function () use($req_param, $nowDate, $BalanceRegisterService, $BalanceModifyService) {
            // ----------------収支運賃テーブルを更新---------------- //
            // 既存の内容を削除
            BalanceFare::where('balance_id', session('balance_id'))->delete();
            // 売上の運賃関連レコードを追加
            $BalanceRegisterService->addFareSales(session('balance_id'), $req_param, $nowDate);
            // 経費の運賃関連レコードを追加
            $BalanceRegisterService->addFareExpenses(session('balance_id'), $req_param, $nowDate);
            // ----------------収支荷役テーブルを更新---------------- //
            // 既存の内容を削除
            BalanceCargoHandling::where('balance_id', session('balance_id'))->delete();
            // 売上の荷役関連レコードを追加
            $BalanceRegisterService->addCargoHandling(session('balance_id'), $req_param, $nowDate);
            // ----------------収支人件費テーブルを更新---------------- //
            // 既存の内容を削除
            BalanceLaborCost::where('balance_id', session('balance_id'))->delete();
            // 経費の人件費関連レコードを追加
            $BalanceRegisterService->addLaborCosts(session('balance_id'), $req_param, $nowDate);
            // ----------------収支その他売上テーブルを更新---------------- //
            // 既存の内容を削除
            BalanceOtherSale::where('balance_id', session('balance_id'))->delete();
            // その他売上のレコードを追加
            $BalanceRegisterService->addOtherSales(session('balance_id'), $req_param, $nowDate);
            // ----------------収支その他経費テーブルを更新---------------- //
            // 既存の内容を削除
            BalanceOtherExpense::where('balance_id', session('balance_id'))->delete();
            // その他経費のレコードを追加
            $BalanceRegisterService->addOtherExpenses(session('balance_id'), $req_param, $nowDate);
            // 売上合計を計算
            $total_sales = $BalanceRegisterService->calcTotalSales(session('balance_id'), $req_param['storage_fee']);
            // 経費合計を計算
            $total_expenses = $BalanceRegisterService->calcTotalExpenses(session('balance_id'), $req_param['storage_expenses']);
            // 利益を計算
            $total_profit = $total_sales - $total_expenses;
            // 収支テーブルを更新
            $BalanceModifyService->updateBalance($req_param['storage_fee'], $req_param['storage_expenses'], $req_param['balance_note'], $total_sales, $total_expenses, $total_profit);
        });
        session()->flash('alert_success', '収支修正が完了しました。');
        // 収支一覧に遷移
        return redirect(session('redirect_url'));
    }
}
