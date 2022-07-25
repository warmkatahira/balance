<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Base;
use App\Models\CargoHandling;
use App\Models\CargoHandlingCustomer;
use App\Models\ShippingMethod;
use App\Models\CustomerShippingMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CustomerService = new CustomerService;
        // セッションに情報を格納
        $CustomerService->inputSession(Auth::user()->base_id);
        // 拠点と指定した拠点の荷主を取得
        $data = $CustomerService->getCustomerAndBase();
        return view('customer.index')->with([
            'customers' => $data['customers'],
            'bases' => $data['bases'],
        ]);
    }

    public function index_search(Request $request)
    {
        // サービスクラスを定義
        $CustomerService = new CustomerService;
        // セッションに情報を格納
        $CustomerService->inputSession($request->base_select);
        // 拠点と指定した拠点の荷主を取得
        $data = $CustomerService->getCustomerAndBase();
        return view('customer.index')->with([
            'customers' => $data['customers'],
            'bases' => $data['bases'],
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
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        Customer::insert($param);
        return redirect()->route('customer.index');
    }

    public function base_info_index(Request $request)
    {
        // セッションに格納
        session(['customer_id' => $request->customer_id]);
        // 荷主の情報を取得
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        return view('customer.base_info_index')->with([
            'customer' => $customer,
        ]);
    }

    public function base_info_update(Request $request)
    {
        // 基本情報を更新
        Customer::where('customer_id', session('customer_id'))->update([
            'customer_name' => $request->customer_name,
            'monthly_storage_fee' => $request->monthly_storage_fee,
            'working_days' => $request->working_days,
        ]);
        return back();
    }

    public function cargo_handling_setting_index(Request $request)
    {
        // セッションに格納
        session(['customer_id' => $request->customer_id]);
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        $cargo_handlings = CargoHandling::all();
        return view('customer.cargo_handling_setting_index')->with([
            'customer' => $customer,
            'cargo_handlings' => $cargo_handlings,
        ]);
    }

    public function cargo_handling_setting_update(Request $request)
    {
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

    public function shipping_method_setting_index(Request $request)
    {
        // セッションに格納
        session(['customer_id' => $request->customer_id]);
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        $shipping_methods = ShippingMethod::all();
        return view('customer.shipping_method_setting_index')->with([
            'customer' => $customer,
            'shipping_methods' => $shipping_methods,
        ]);
    }

    public function shipping_method_setting_update(Request $request)
    {
        // 保存する配送方法設定を格納する配列をセット
        $param = [];
        // 保存する配送方法設定が無い場合
        if (!$request->has('fare_unit_price')) {
            // customer_idを指定してレコードを削除
            CustomerShippingMethod::where('customer_id', session('customer_id'))->delete();
            return back();
        }
        // 保存する配送方法設定を配列に格納（荷役設定の分だけループ）
        // 運賃単価
        foreach($request->fare_unit_price as $key => $value) {
            $param = $param + array($key => ['fare_unit_price' => $value]);
        }
        // 運賃経費
        foreach($request->fare_expense as $key => $value) {
            $param[$key] += array('fare_expense' => $value);
        }
        // 配送方法設定を保存する荷主を特定
        $customer = Customer::find(session('customer_id'));
        // 配送方法設定を保存
        $customer->shipping_methods()->sync($param);
        return back();
    }
}
