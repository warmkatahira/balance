<?php

namespace App\Services;

use App\Models\SalesPlan;
use Carbon\Carbon;

class SalesPlanService
{
    public function getSalesPlan($base_id, $from_date, $to_date)
    {
        // 日付をCarbonでインスタンス化
        $from_date = new Carbon($from_date);
        $to_date = new Carbon($to_date);
        // セッションに情報を格納
        session(['base_id' => $base_id]);
        session(['month_select_from' => $from_date->format('Y-m')]);
        session(['month_select_to' => $to_date->format('Y-m')]);
        // 指定された設定年月の設定を取得
        $sales_plans = SalesPlan::where('base_id', $base_id)
                                    ->whereBetween('plan_date', [$from_date->format('Ym'), $to_date->format('Ym')])
                                    ->orderBy('plan_date', 'asc')
                                    ->get();
        return $sales_plans;
    }
}