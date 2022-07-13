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
use App\Models\Expense;
use App\Models\BalanceExpense;
use App\Models\LaborCost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BalanceRegisterController extends Controller
{
    public function index()
    {   
        $shipping_methods = ShippingMethod::all();
        $other_expenses = Expense::where('expense_category', '変動')->get();
        $balances = Balance::all();
        $own_base_customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $labor_costs = LaborCost::orderBy('labor_cost_id', 'asc')->get();
        return view('balance_register.index')->with([
            'balances' => $balances,
            'shipping_methods' => $shipping_methods,
            'other_expenses' => $other_expenses,
            'own_base_customers' => $own_base_customers,
            'labor_costs' => $labor_costs,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    // 指定された収支の情報を取得する
    public function balance_get_ajax($balance_id)
    {
        // 必要な情報をjoinして生成する
        $balance = Balance::where('balance_id', $balance_id)
                    ->join('bases', 'balances.balance_base_id', '=', 'bases.base_id')
                    ->join('customers', 'balances.balance_customer_id', '=', 'customers.customer_id')
                    ->select('balances.*', 'bases.*', 'customers.*')
                    ->first();
        $fare_sum_sales = BalanceFare::where('balance_id', $balance_id)->where('fare_balance_category', '売上')->sum('fare_amount');
        $cargo_handling_sum_sales = BalanceCargoHandling::where('balance_id', $balance_id)->sum('cargo_handling_amount');
        $fare_sum_expenses = BalanceFare::where('balance_id', $balance_id)->where('fare_balance_category', '経費')->sum('fare_amount');
        $labor_costs_sum_expenses = BalanceLaborCost::where('balance_id', $balance_id)->sum('labor_costs');
        $other_expense_amount_sum_expenses = BalanceExpense::where('balance_id', $balance_id)->sum('expense_amount');
        // 結果を返す
        return response()->json(
            ['balance' => $balance,
             'fare_sum_sales' => $fare_sum_sales,
             'cargo_handling_sum_sales' => $cargo_handling_sum_sales,
             'fare_sum_expenses' => $fare_sum_expenses,
             'labor_costs_sum_expenses' => $labor_costs_sum_expenses,
             'other_expense_amount_sum_expenses' => $other_expense_amount_sum_expenses,
            ]);
    }

    // 選択された荷主に合わせて、荷役を取得する
    public function balance_register_customer_data_get_ajax($customer_id)
    {
        // 荷主IDで荷役登録情報を取得
        $cargo_handlings = CargoHandlingCustomer::where('customer_id', $customer_id)
                            ->join('cargo_handlings', 'cargo_handling_customer.cargo_handling_id', '=', 'cargo_handlings.cargo_handling_id')
                            ->select('cargo_handling_customer.*', 'cargo_handlings.cargo_handling_name')
                            ->get();
        // 月間保管費を稼働日数で割る
        $customer = Customer::where('customer_id', $customer_id)->first();
        $storage_fee = 0;
        if($customer->monthly_storage_fee > 0 && $customer->working_days > 0){
            // 商を切り捨て
            $storage_fee = floor($customer->monthly_storage_fee / $customer->working_days);
        }
        // 結果を返す
        return response()->json(
            ['cargo_handlings' => $cargo_handlings,
             'customer' => $customer,
             'storage_fee' => $storage_fee,
            ]);
    }

    // 収支登録処理
    public function register(Request $request)
    {   
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // リクエストパラメータを必要な分だけ取得
        $req_param = $request->only([
            'balance_date',
            'customer_id',
            'storage_fee',
            'balance_note',
            'shipping_method_name_sales',
            'box_quantity_sales',
            'fare_unit_price_sales',
            'fare_amount_sales',
            'cargo_handling_name',
            'operation_quantity',
            'cargo_handling_unit_price',
            'cargo_handling_amount',
            'shipping_method_name_expenses',
            'box_quantity_expenses',
            'fare_unit_price_expenses',
            'fare_amount_expenses',
            'labor_cost_category',
            'working_time',
            'hourly_wage',
            'labor_costs',
            'other_expense_name',
            'other_expense_amount',
        ]);

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
        // レコード追加し、自動増分IDを取得
        $inserted_id = Balance::insertGetId($param);
        
        //　売上と経費の変数を用意(売上は保管費を初期値とする)
        $sales = is_null($req_param['storage_fee']) ? 0 : $req_param['storage_fee'];
        $expenses = 0;

        // 売上の運賃関連レコードを追加
        if(isset($req_param['shipping_method_name_sales'])){
            for($i = 0; $i < count($req_param['shipping_method_name_sales']); $i++) {
                $param = [
                    'balance_id' => $inserted_id,
                    'fare_balance_category' => '売上',
                    'shipping_method_name' => $req_param['shipping_method_name_sales'][$i],
                    'box_quantity' => is_null($req_param['box_quantity_sales'][$i]) ? 0 : $req_param['box_quantity_sales'][$i],
                    'fare_unit_price' => is_null($req_param['fare_unit_price_sales'][$i]) ? 0 : $req_param['fare_unit_price_sales'][$i],
                    'fare_amount' => is_null($req_param['fare_amount_sales'][$i]) ? 0 : $req_param['fare_amount_sales'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceFare::insert($param);

                // 売上を加算
                $sales += $req_param['fare_amount_sales'][$i];
            }
        }
        // 経費の運賃関連レコードを追加
        if(isset($req_param['shipping_method_name_expenses'])){
            for($i = 0; $i < count($req_param['shipping_method_name_expenses']); $i++) {
                $param = [
                    'balance_id' => $inserted_id,
                    'fare_balance_category' => '経費',
                    'shipping_method_name' => $req_param['shipping_method_name_expenses'][$i],
                    'box_quantity' => is_null($req_param['box_quantity_expenses'][$i]) ? 0 : $req_param['box_quantity_expenses'][$i],
                    'fare_unit_price' => is_null($req_param['fare_unit_price_expenses'][$i]) ? 0 : $req_param['fare_unit_price_expenses'][$i],
                    'fare_amount' => is_null($req_param['fare_amount_expenses'][$i]) ? 0 : $req_param['fare_amount_expenses'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceFare::insert($param);

                // 経費を加算
                $expenses += $req_param['fare_amount_expenses'][$i];
            }
        }
        // 売上の荷役関連レコードを追加
        if(isset($req_param['cargo_handling_name'])){
            for($i = 0; $i < count($req_param['cargo_handling_name']); $i++) {
                $param = [
                    'balance_id' => $inserted_id,
                    'cargo_handling_name' => $req_param['cargo_handling_name'][$i],
                    'operation_quantity' => is_null($req_param['operation_quantity'][$i]) ? 0 : $req_param['operation_quantity'][$i],
                    'cargo_handling_unit_price' => is_null($req_param['cargo_handling_unit_price'][$i]) ? 0 : $req_param['cargo_handling_unit_price'][$i],
                    'cargo_handling_amount' => is_null($req_param['cargo_handling_amount'][$i]) ? 0 : $req_param['cargo_handling_amount'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceCargoHandling::insert($param);

                // 売上を加算
                $sales += $req_param['cargo_handling_amount'][$i];
            }
        }
        // 経費の人件費関連レコードを追加
        for($i = 0; $i < count($req_param['labor_cost_category']); $i++) {
            $param = [
                'balance_id' => $inserted_id,
                'labor_cost_category' => $req_param['labor_cost_category'][$i],
                'working_time' => is_null($req_param['working_time'][$i]) ? 0 : $req_param['working_time'][$i],
                'hourly_wage' => is_null($req_param['hourly_wage'][$i]) ? 0 : $req_param['hourly_wage'][$i],
                'labor_costs' => is_null($req_param['labor_costs'][$i]) ? 0 : $req_param['labor_costs'][$i],
                'created_at' => $nowDate,
                'updated_at' => $nowDate,
            ];
            // レコード追加
            BalanceLaborCost::insert($param);

            // 経費を加算
            $expenses += $req_param['labor_costs'][$i];
        }

        // その他経費のレコードを追加
        if(isset($req_param['other_expense_name'])){
            for($i = 0; $i < count($req_param['other_expense_name']); $i++) {
                $param = [
                    'balance_id' => $inserted_id,
                    'expense_name' => $req_param['other_expense_name'][$i],
                    'expense_amount' => is_null($req_param['other_expense_amount'][$i]) ? 0 : $req_param['other_expense_amount'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceExpense::insert($param);

                // 経費を加算
                $expenses += $req_param['other_expense_amount'][$i];
            }
        }
        // 売上と経費と利益を更新
        $balance = Balance::find($inserted_id);
        $balance->sales = $sales;
        $balance->expenses = $expenses;
        $balance->profit = $sales - $expenses;
        $balance->save();

        return redirect()->route('balance_register.index');
    }

    public function detail_index($balance_id)
    {
        session(['balance_id' => $balance_id]);
        $balance = Balance::where('balance_id', $balance_id)->first();
        $balance_fare_sales = BalanceFare::where('balance_id', $balance_id)->where('fare_balance_category', '売上')->get();
        $balance_cargo_handlings = BalanceCargoHandling::where('balance_id', $balance_id)->get();
        $balance_fare_expenses = BalanceFare::where('balance_id', $balance_id)->where('fare_balance_category', '経費')->get();
        $balance_labor_costs = BalanceLaborCost::where('balance_id', $balance_id)->get();
        $balance_other_expenses = BalanceExpense::where('balance_id', $balance_id)->get();
        return view('balance_register.detail_index')->with([
            'balance' => $balance,
            'balance_fare_sales' => $balance_fare_sales,
            'balance_cargo_handlings' => $balance_cargo_handlings,
            'balance_fare_expenses' => $balance_fare_expenses,
            'balance_labor_costs' => $balance_labor_costs,
            'balance_other_expenses' => $balance_other_expenses,
        ]);
    }

    public function delete($balance_id)
    {
        // 削除可能な権限か確認

        // 削除可能なユーザーか確認

        Balance::where('balance_id', $balance_id)->delete();
        return redirect()->route('balance_register.index');
    }
}
