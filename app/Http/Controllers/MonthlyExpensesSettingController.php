<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyExpensesSetting;
use App\Models\Base;
use App\Models\ExpensesItem;
use Carbon\Carbon;

use App\Services\MonthlyExpensesSettingService;

class MonthlyExpensesSettingController extends Controller
{
    public function index(Request $request)
    {
        // 現在の日時を取得
        $date = new Carbon('now');
        // サービスクラスを定義
        $MonthlyExpensesSettingService = new MonthlyExpensesSettingService;
        // 指定された条件の設定を取得
        $data = $MonthlyExpensesSettingService->getMonthlyExpensesSetting($request->base_id, $date);
        return view('monthly_expenses_setting.index')->with([
            'monthly_expenses_settings' => $data['monthly_expenses_settings'],
            'expenses_items' => $data['expenses_items'],
        ]);
    }

    public function index_search(Request $request)
    {
        // サービスクラスを定義
        $MonthlyExpensesSettingService = new MonthlyExpensesSettingService;
        // 指定された条件の設定を取得
        $data = $MonthlyExpensesSettingService->getMonthlyExpensesSetting(session('base_id'), $request->month_select);
        return view('monthly_expenses_setting.index')->with([
            'monthly_expenses_settings' => $data['monthly_expenses_settings'],
            'expenses_items' => $data['expenses_items'],
        ]);
    }

    public function register(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 計画年月をフォーマット
        $setting_date = new Carbon($request->setting_date);
        $setting_date = $setting_date->format('Ym');
        // パラメータをセットして追加
        $param = [
            'base_id' => session('base_id'),
            'setting_date' => $setting_date,
            'expenses_item_id' => $request->expenses_item_id,
            'expenses_amount' => $request->expenses_amount,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        MonthlyExpensesSetting::insert($param);
        return back();
    }

    public function delete($monthly_expenses_setting_id)
    {
        // 削除可能な権限か確認

        // 削除可能なユーザーか確認

        MonthlyExpensesSetting::where('monthly_expenses_setting_id', $monthly_expenses_setting_id)->delete();
        return back();
    }
}
