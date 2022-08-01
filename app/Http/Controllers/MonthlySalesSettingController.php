<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\MonthlySalesSetting;
use App\Models\Customer;
use App\Models\SalesItem;

class MonthlySalesSettingController extends Controller
{
    public function index(Request $request)
    {
        // 現在の日時を取得
        $date = new Carbon('now');
        // セッションに格納
        session(['customer_id' => $request->customer_id]);
        // 現在の設定を取得
        $monthly_sales_settings = MonthlySalesSetting::where('customer_id', $request->customer_id)->get(); 
        // 荷主の情報を取得
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        // 売上項目マスタの情報を取得
        $sales_items = SalesItem::all();
        return view('monthly_sales_setting.index')->with([
            'monthly_sales_settings' => $monthly_sales_settings,
            'customer' => $customer,
            'sales_items' => $sales_items,
        ]);
    }

    public function register(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // パラメータをセットして追加
        $param = [
            'customer_id' => session('customer_id'),
            'sales_item_id' => $request->sales_item_id,
            'sales_amount' => $request->sales_amount,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        MonthlySalesSetting::insert($param);
        return back();
    }

    public function delete(Request $request)
    {
        // 削除可能な権限か確認

        // 削除可能なユーザーか確認

        MonthlySalesSetting::where('monthly_sales_setting_id', $request->monthly_sales_setting_id)->delete();
        return back();
    }
}
