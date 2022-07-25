<?php

namespace App\Services;

use App\Models\MonthlyExpensesSetting;
use App\Models\ExpensesItem;
use Carbon\Carbon;

class MonthlyExpensesSettingService
{
    public function getMonthlyExpensesSetting($base_id, $date)
    {
        // 日付をCarbonでインスタンス化
        $date = new Carbon($date);
        // セッションに情報を格納
        session(['base_id' => $base_id]);
        session(['month_select' => $date->format('Y-m')]);
        // 指定された設定年月の設定を取得
        $monthly_expenses_settings = MonthlyExpensesSetting::where('base_id', $base_id)
                                    ->where('setting_date', $date->format('Ym'))
                                    ->get();
        // 経費区分が変動以外の経費項目マスタを取得
        $expenses_items = ExpensesItem::where('expenses_item_category', '!=', '変動')->get();
        return with([
            'monthly_expenses_settings' => $monthly_expenses_settings,
            'expenses_items' => $expenses_items,
        ]);
    }
}