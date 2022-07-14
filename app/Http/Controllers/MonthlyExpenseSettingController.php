<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyExpenseSetting;
use App\Models\Base;
use App\Models\Expense;
use Carbon\Carbon;

class MonthlyExpenseSettingController extends Controller
{
    public function index($base_id)
    {
        session(['base_id' => $base_id]);
        $base = Base::where('base_id', $base_id)->first();
        $monthly_expense_settings = MonthlyExpenseSetting::where('base_id', $base_id)->get();
        // 区分が変動以外の経費を設定対象とする
        $expenses = Expense::where('expense_category', '!=', '変動')->get();
        return view('monthly_expense_setting.index')->with([
            'base' => $base,
            'monthly_expense_settings' => $monthly_expense_settings,
            'expenses' => $expenses,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'base_id' => session('base_id'),
            'setting_date' => $request->setting_date_year . $request->setting_date_month,
            'expense_id' => $request->expense_id,
            'expense_amount' => $request->expense_amount,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        MonthlyExpenseSetting::insert($param);
        return back();
    }

    public function delete($monthly_expense_setting_id)
    {
        // 削除可能な権限か確認

        // 削除可能なユーザーか確認

        MonthlyExpenseSetting::where('monthly_expense_setting_id', $monthly_expense_setting_id)->delete();
        return back();
    }
}
