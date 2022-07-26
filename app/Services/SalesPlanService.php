<?php

namespace App\Services;

use App\Models\SalesPlan;
use Carbon\Carbon;

class SalesPlanService
{
    public function getSalesPlan($base_id, $date)
    {
        // 日付をCarbonでインスタンス化
        $date = new Carbon($date);
        // セッションに情報を格納
        session(['base_id' => $base_id]);
        session(['month_select' => $date->format('Y-m')]);
        // 指定された設定年月の設定を取得
        $sales_plans = SalesPlan::where('base_id', $base_id)
                                    ->where('plan_date', $date->format('Ym'))
                                    ->get();
        return $sales_plans;
    }
}