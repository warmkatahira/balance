<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SalesPlan;
use App\Models\Base;

use App\Services\SalesPlanService;

class SalesPlanController extends Controller
{
    public function index(Request $request)
    {
        // 現在の日時を取得
        $date = new Carbon('now');
        // サービスクラスを定義
        $SalesPlanService = new SalesPlanService;
        // 指定された条件の設定を取得
        $sales_plans = $SalesPlanService->getSalesPlan($request->base_id, $date, $date);
        // 拠点の情報を取得
        $base = Base::where('base_id', $request->base_id)->first();
        return view('sales_plan.index')->with([
            'sales_plans' => $sales_plans,
            'base' => $base,
        ]);
    }

    public function index_search(Request $request)
    {
        // サービスクラスを定義
        $SalesPlanService = new SalesPlanService;
        // 指定された条件の設定を取得
        $sales_plans = $SalesPlanService->getSalesPlan(session('base_id'), $request->month_select_from, $request->month_select_to);
        return view('sales_plan.index')->with([
            'sales_plans' => $sales_plans,
        ]);
    }

    public function register(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 計画年月をフォーマット
        $plan_date = new Carbon($request->plan_date);
        $plan_date = $plan_date->format('Ym');
        // パラメータをセットして追加
        $param = [
            'base_id' => session('base_id'),
            'plan_date' => $plan_date,
            'sales_plan_amount' => $request->sales_plan_amount,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        SalesPlan::insert($param);
        return back();
    }

    public function delete($sales_plan_id)
    {
        // 削除可能な権限か確認

        // 削除可能なユーザーか確認

        SalesPlan::where('sales_plan_id', $sales_plan_id)->delete();
        return back();
    }

    public function sales_plan_register_validation_ajax(Request $request)
    {
        // 計画年月をフォーマット
        $plan_date = new Carbon($request->plan_date);
        $plan_date = $plan_date->format('Ym');
        // 存在する売上計画でないか確認
        $sales_plan = SalesPlan::where('base_id', session('base_id'))
                    ->where('plan_date', $plan_date)
                    ->first();
        // 結果を返す
        return response()->json([
            'sales_plan' => $sales_plan,
        ]);
    }
    
}
