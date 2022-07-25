<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaborCost;
use App\Models\Base;

class LaborCostSettingController extends Controller
{
    public function index(Request $request)
    {
        // 拠点IDをセッションに格納
        session(['base_id' => $request->base_id]);
        // 人件費設定を取得
        $labor_costs = LaborCost::where('base_id', $request->base_id)
                        ->orderBy('labor_cost_id', 'asc')
                        ->get();
        // 拠点の情報を取得
        $base = Base::where('base_id', $request->base_id)->first();
        return view('labor_cost_setting.index')->with([
            'labor_costs' => $labor_costs,
            'base' => $base,
        ]);
    }

    public function update(Request $request)
    {
        for($i = 0; $i < count($request->labor_cost_id); $i++) {
            // 更新
            LaborCost::where('base_id', session('base_id'))
            ->where('labor_cost_id', $request->labor_cost_id[$i])
            ->update([
                'hourly_wage' => $request->hourly_wage[$i],
            ]);
        }
        return back();
    }
}
