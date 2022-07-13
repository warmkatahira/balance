<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Base;
use App\Models\CargoHandling;
use App\Models\CargoHandlingCustomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $bases = Base::all();
        return view('customer.index')->with([
            'customers' => $customers,
            'bases' => $bases,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function sort()
    {
        $customers = Customer::all();
        return view('customer.index')->with([
            'customers' => $customers,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'customer_name' => $request->customer_name,
            'register_user_id' => Auth::user()->id,
            'control_base_id' => $request->base_id,
            'monthly_storage_fee' => $request->monthly_storage_fee,
            'working_days' => $request->working_days,
            'handling_fee_category' => $request->handling_fee_category,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        Customer::insert($param);
        return redirect()->route('customer.index');
    }

    // 荷主マスタ詳細表示の処理
    public function detail($customer_id)
    {
        $customer = Customer::where('customer_id', $customer_id)->first();
        $cargo_handlings = CargoHandling::all();
        session(['customer_id' => $customer_id]);
        return view('customer.detail')->with([
            'customer' => $customer,
            'cargo_handlings' => $cargo_handlings,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    // 保存時の処理
    public function customer_setting_update(Request $request)
    {
        // 基本設定を更新
        Customer::where('customer_id', session('customer_id'))->update([
            'customer_name' => $request->customer_name,
            'monthly_storage_fee' => $request->monthly_storage_fee,
            'working_days' => $request->working_days,
            'handling_fee_category' => $request->handling_fee_category,
        ]);
        // 保存する荷役設定を格納する配列をセット
        $param = [];
        // 保存する荷役設定が無い場合
        if (!$request->has('cargo_handling_unit_price')) {
            // customer_idを指定してレコードを削除
            CargoHandlingCustomer::where('customer_id', session('customer_id'))->delete();
            return back();
        }
        // 保存する荷役設定を配列に格納（荷役設定の分だけループ）
        // 荷役単価(収支登録初期表示は一旦Falseで追加しておく)
        foreach($request->cargo_handling_unit_price as $key => $value) {
            $param = $param + array($key => ['cargo_handling_unit_price' => $value, 'balance_register_default_disp' => false]);
        }
        // 収支登録初期表示(CheckboxがONのものだけ送信されてくるので、ONのデータだけ値を更新する)
        foreach($request->balance_register_default_disp as $key => $value) {
            $param[$key]['balance_register_default_disp'] = true;
        }
        // 荷役設定を保存する荷主を特定
        $customer = Customer::find(session('customer_id'));
        // 荷役設定を保存
        $customer->cargo_handlings()->sync($param);
        return back();
    }
}
