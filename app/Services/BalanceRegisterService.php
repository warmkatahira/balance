<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Balance;
use App\Models\BalanceFare;
use App\Models\BalanceCargoHandling;
use App\Models\BalanceLaborCost;
use App\Models\BalanceOtherExpense;
use App\Models\BalanceOtherSale;
use Carbon\Carbon;

class BalanceRegisterService
{
    // リクエストパラメータを取得
    public function getRequestParameter($request)
    {
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
            'labor_cost_name',
            'working_time',
            'hourly_wage',
            'labor_costs',
            'other_expenses_name',
            'other_expenses_amount',
            'other_sales_name',
            'other_sales_amount',
        ]);
        return $req_param;
    }

    public function addFareSales($balance_id, $req_param, $nowDate)
    {
        // 売上の運賃関連レコードを追加
        if(isset($req_param['shipping_method_name_sales'])){
            for($i = 0; $i < count($req_param['shipping_method_name_sales']); $i++) {
                if($req_param['fare_amount_sales'][$i]){
                    $param = [
                        'balance_id' => $balance_id,
                        'fare_balance_category' => 'sales',
                        'shipping_method_name' => $req_param['shipping_method_name_sales'][$i],
                        'box_quantity' => is_null($req_param['box_quantity_sales'][$i]) ? 0 : $req_param['box_quantity_sales'][$i],
                        'fare_unit_price' => is_null($req_param['fare_unit_price_sales'][$i]) ? 0 : $req_param['fare_unit_price_sales'][$i],
                        'fare_amount' => is_null($req_param['fare_amount_sales'][$i]) ? 0 : $req_param['fare_amount_sales'][$i],
                        'created_at' => $nowDate,
                        'updated_at' => $nowDate,
                    ];
                    // レコード追加
                    BalanceFare::insert($param);
                }
            }
        }
        return;
    }

    public function addFareExpenses($balance_id, $req_param, $nowDate)
    {
        // 経費の運賃関連レコードを追加
        if(isset($req_param['shipping_method_name_expenses'])){
            for($i = 0; $i < count($req_param['shipping_method_name_expenses']); $i++) {
                $param = [
                    'balance_id' => $balance_id,
                    'fare_balance_category' => 'expenses',
                    'shipping_method_name' => $req_param['shipping_method_name_expenses'][$i],
                    'box_quantity' => is_null($req_param['box_quantity_expenses'][$i]) ? 0 : $req_param['box_quantity_expenses'][$i],
                    'fare_unit_price' => is_null($req_param['fare_unit_price_expenses'][$i]) ? 0 : $req_param['fare_unit_price_expenses'][$i],
                    'fare_amount' => is_null($req_param['fare_amount_expenses'][$i]) ? 0 : $req_param['fare_amount_expenses'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceFare::insert($param);
            }
        }
        return;
    }

    public function addCargoHandling($balance_id, $req_param, $nowDate)
    {
        // 売上の荷役関連レコードを追加
        if(isset($req_param['cargo_handling_name'])){
            for($i = 0; $i < count($req_param['cargo_handling_name']); $i++) {
                $param = [
                    'balance_id' => $balance_id,
                    'cargo_handling_name' => $req_param['cargo_handling_name'][$i],
                    'operation_quantity' => is_null($req_param['operation_quantity'][$i]) ? 0 : $req_param['operation_quantity'][$i],
                    'cargo_handling_unit_price' => is_null($req_param['cargo_handling_unit_price'][$i]) ? 0 : $req_param['cargo_handling_unit_price'][$i],
                    'cargo_handling_amount' => is_null($req_param['cargo_handling_amount'][$i]) ? 0 : $req_param['cargo_handling_amount'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceCargoHandling::insert($param);
            }
        }
        return;
    }

    public function addLaborCosts($balance_id, $req_param, $nowDate)
    {
        // 経費の人件費関連レコードを追加
        for($i = 0; $i < count($req_param['labor_cost_name']); $i++) {
            $param = [
                'balance_id' => $balance_id,
                'labor_cost_name' => $req_param['labor_cost_name'][$i],
                'working_time' => is_null($req_param['working_time'][$i]) ? 0 : $req_param['working_time'][$i],
                'hourly_wage' => is_null($req_param['hourly_wage'][$i]) ? 0 : $req_param['hourly_wage'][$i],
                'labor_costs' => is_null($req_param['labor_costs'][$i]) ? 0 : $req_param['labor_costs'][$i],
                'created_at' => $nowDate,
                'updated_at' => $nowDate,
            ];
            // レコード追加
            BalanceLaborCost::insert($param);
        }
        return;
    }

    public function addOtherSales($balance_id, $req_param, $nowDate)
    {
        // その他売上のレコードを追加
        if(isset($req_param['other_sales_name'])){
            for($i = 0; $i < count($req_param['other_sales_name']); $i++) {
                $param = [
                    'balance_id' => $balance_id,
                    'other_sales_name' => $req_param['other_sales_name'][$i],
                    'other_sales_amount' => is_null($req_param['other_sales_amount'][$i]) ? 0 : $req_param['other_sales_amount'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceOtherSale::insert($param);
            }
        }
        return;
    }

    public function addOtherExpenses($balance_id, $req_param, $nowDate)
    {
        // その他経費のレコードを追加
        if(isset($req_param['other_expenses_name'])){
            for($i = 0; $i < count($req_param['other_expenses_name']); $i++) {
                $param = [
                    'balance_id' => $balance_id,
                    'other_expenses_name' => $req_param['other_expenses_name'][$i],
                    'other_expenses_amount' => is_null($req_param['other_expenses_amount'][$i]) ? 0 : $req_param['other_expenses_amount'][$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                // レコード追加
                BalanceOtherExpense::insert($param);
            }
        }
        return;
    }

    // 売上の金額を集計
    public function calcTotalSales($balance_id, $storage_fee)
    {
        // 運賃売上
        $total_sales = BalanceFare::where('balance_id', $balance_id)
                        ->where('fare_balance_category', 'sales')
                        ->sum('fare_amount');
        // 荷役売上
        $total_sales += BalanceCargoHandling::where('balance_id', $balance_id)
                        ->sum('cargo_handling_amount');
        // その他売上
        $total_sales += BalanceOtherSale::where('balance_id', $balance_id)
                        ->sum('other_sales_amount');
        // 保管費売上
        $total_sales += $storage_fee;
        return $total_sales;
    }

    // 経費の金額を集計
    public function calcTotalExpenses($balance_id)
    {
        // 運賃経費
        $total_expenses = BalanceFare::where('balance_id', $balance_id)
                            ->where('fare_balance_category', 'expenses')
                            ->sum('fare_amount');
        // 人件費
        $total_expenses += BalanceLaborCost::where('balance_id', $balance_id)
                            ->sum('labor_costs');
        // その他売上
        $total_expenses += BalanceOtherExpense::where('balance_id', $balance_id)
                            ->sum('other_expenses_amount');
        return $total_expenses;
    }

    // 売上/経費/利益を更新
    public function updateTotalAmount($balance_id, $total_sales, $total_expenses, $date)
    {
        $balance = Balance::find($balance_id);
        $balance->sales = $total_sales;
        $balance->expenses = $total_expenses;
        $balance->profit = $total_sales - $total_expenses;
        $balance->updated_at = $date;
        $balance->save();
        return;
    }
}