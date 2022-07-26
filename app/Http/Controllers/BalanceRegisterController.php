<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Base;
use App\Models\Customer;
use App\Models\ShippingMethod;
use App\Models\CargoHandling;
use App\Models\BalanceFare;
use App\Models\BalanceCargoHandling;
use App\Models\BalanceLaborCost;
use App\Models\CargoHandlingCustomer;
use App\Models\ExpensesItem;
use App\Models\SalesItem;
use App\Models\BalanceOtherExpense;
use App\Models\BalanceOtherSale;
use App\Models\LaborCost;
use App\Models\CustomerShippingMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Services\BalanceRegisterService;

use App\Http\Requests\BalanceRegisterRequest;

class BalanceRegisterController extends Controller
{
    public function index()
    {   
        $expenses_items = ExpensesItem::where('expenses_item_category', '変動')->get();
        $sales_items = SalesItem::all();
        $balances = Balance::all();
        $own_base_customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $labor_costs = LaborCost::where('base_id', Auth::user()->base_id)
                        ->orderBy('labor_cost_id', 'asc')->get();
        return view('balance_register.index')->with([
            'balances' => $balances,
            'expenses_items' => $expenses_items,
            'sales_items' => $sales_items,
            'own_base_customers' => $own_base_customers,
            'labor_costs' => $labor_costs,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    // 選択された荷主に合わせて、荷役と配送方法を取得する
    public function balance_register_customer_data_get_ajax($customer_id)
    {
        $storage_fee = 0;
        // IDが0以外の時は実行
        if($customer_id != 0){
            // 荷主IDで荷役設定を取得
            $cargo_handlings = CargoHandlingCustomer::where('customer_id', $customer_id)
                                ->join('cargo_handlings', 'cargo_handling_customer.cargo_handling_id', '=', 'cargo_handlings.cargo_handling_id')
                                ->select('cargo_handling_customer.*', 'cargo_handlings.cargo_handling_name')
                                ->get();
            // 荷主IDで配送方法設定を取得
            $shipping_methods = CustomerShippingMethod::where('customer_id', $customer_id)
                                ->join('shipping_methods', 'customer_shipping_method.shipping_method_id', '=', 'shipping_methods.shipping_method_id')
                                ->select('customer_shipping_method.*', 'shipping_methods.*')
                                ->get();
            // 月間保管費を稼働日数で割る
            $customer = Customer::where('customer_id', $customer_id)->first();
            if($customer->monthly_storage_fee > 0 && $customer->working_days > 0){
                // 商を切り捨て
                $storage_fee = floor($customer->monthly_storage_fee / $customer->working_days);
            }
        }
        if($customer_id == 0){
            $cargo_handlings = array();
            $shipping_methods = array();
            $customer = array();
        }
        // 結果を返す
        return response()->json([
            'cargo_handlings' => $cargo_handlings,
            'shipping_methods' => $shipping_methods,
            'customer' => $customer,
            'storage_fee' => $storage_fee,
        ]);
    }

    public function balance_register_validation_ajax(Request $request)
    {
        // 存在する収支でないか確認
        $balance = Balance::where('balance_customer_id', $request->balance_customer_id)
                    ->where('balance_date', $request->balance_date)
                    ->first();
        // 結果を返す
        return response()->json([
            'balance' => $balance,
        ]);
    }

    // 収支登録処理
    public function register(Request $request)
    {   
        // サービスクラスを定義
        $BalanceRegisterService = new BalanceRegisterService;
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // リクエストパラメータを取得
        $req_param = $BalanceRegisterService->getRequestParameter($request);
        // 追加情報を変数に格納
        $param = [
            'register_user_id' => Auth::user()->id,
            'balance_base_id' => Auth::user()->base_id,
            'balance_date' => $req_param['balance_date'],
            'balance_customer_id' => $req_param['customer_id'],
            'storage_fee' => is_null($req_param['storage_fee']) ? 0 : $req_param['storage_fee'],
            'balance_note' => $req_param['balance_note'],
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        // レコード追加し、自動増分IDを取得(収支IDとなる)
        $inserted_id = Balance::insertGetId($param);
        // 売上の運賃関連レコードを追加
        $BalanceRegisterService->addFareSales($inserted_id, $req_param, $nowDate);
        // 経費の運賃関連レコードを追加
        $BalanceRegisterService->addFareExpenses($inserted_id, $req_param, $nowDate);
        // 売上の荷役関連レコードを追加
        $BalanceRegisterService->addCargoHandling($inserted_id, $req_param, $nowDate);
        // 経費の人件費関連レコードを追加
        $BalanceRegisterService->addLaborCosts($inserted_id, $req_param, $nowDate);
        // その他売上のレコードを追加
        $BalanceRegisterService->addOtherSales($inserted_id, $req_param, $nowDate);
        // その他経費のレコードを追加
        $BalanceRegisterService->addOtherExpenses($inserted_id, $req_param, $nowDate);
        // 売上合計を計算
        $total_sales = $BalanceRegisterService->calcTotalSales($inserted_id, $req_param['storage_fee']);
        // 経費合計を計算
        $total_expenses = $BalanceRegisterService->calcTotalExpenses($inserted_id);
        // 売上/経費/利益を更新
        $BalanceRegisterService->updateTotalAmount($inserted_id, $total_sales, $total_expenses, $nowDate);
        session()->flash('alert_success', '収支登録が完了しました。');
        return redirect()->route('home.index');
    }
}
