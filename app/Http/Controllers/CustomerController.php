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
            'monthly_storage_expenses' => $request->monthly_storage_expenses,
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
        // 拠点情報を取得
        $bases = Base::all();
        return view('customer.base_info_index')->with([
            'customer' => $customer,
            'bases' => $bases,
        ]);
    }

    public function base_info_update(Request $request)
    {
        // 基本情報を更新
        Customer::where('customer_id', session('customer_id'))->update([
            'control_base_id' => $request->base_id,
            'customer_name' => $request->customer_name,
            'monthly_storage_fee' => $request->monthly_storage_fee,
            'monthly_storage_expenses' => $request->monthly_storage_expenses,
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
        $cargo_handling_settings = CargoHandlingCustomer::where('customer_id', $request->customer_id)
                                    ->orderBy('cargo_handling_id', 'asc')
                                    ->get();
        return view('customer.cargo_handling_setting_index')->with([
            'customer' => $customer,
            'cargo_handlings' => $cargo_handlings,
            'cargo_handling_settings' => $cargo_handling_settings,
        ]);
    }

    // 荷役設定の更新処理
    public function cargo_handling_setting_update(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // パラメータがない=全ての設定を削除
        if (!$request->has('cargo_handling_unit_price')) {
            CargoHandlingCustomer::where('customer_id', session('customer_id'))->delete();
        }
        // パラメータがあれば更新処理を実施
        if ($request->has('cargo_handling_unit_price')) {
            foreach($request->cargo_handling_unit_price as $key => $value) {
                // スプリットしてcargo_handling_idを取得
                $split_key = explode('-', $key); 
                // 追加の場合は、設定を追加
                if ($split_key[4] == 'add'){
                    $param = [
                        'customer_id' => session('customer_id'),
                        'cargo_handling_id' => $split_key[0],
                        'cargo_handling_unit_price' => $request->cargo_handling_unit_price[$key],
                        'balance_register_default_disp' => isset($request->balance_register_default_disp[$key]) ? 1 : 0,
                        'cargo_handling_note' => $request->cargo_handling_note[$key],
                        'created_at' => $nowDate,
                        'updated_at' => $nowDate,
                    ];
                    // レコード追加
                    CargoHandlingCustomer::insert($param);
                }
                // 既存の設定は内容を更新
                if ($split_key[4] == 'kizon'){
                    $cargo_handling_customer = CargoHandlingCustomer::find($split_key[3]);
                    $cargo_handling_customer->cargo_handling_unit_price = $request->cargo_handling_unit_price[$key];
                    $cargo_handling_customer->balance_register_default_disp = isset($request->balance_register_default_disp[$key]) ? 1 : 0;
                    $cargo_handling_customer->cargo_handling_note = $request->cargo_handling_note[$key];
                    $cargo_handling_customer->save();
                } 
                // 設定を削除
                if ($split_key[4] == 'del'){
                    CargoHandlingCustomer::where('cargo_handling_customer_id', $split_key[3])->delete();
                } 
            }
        }
        return back();
    }

    public function shipping_method_setting_index(Request $request)
    {
        // セッションに格納
        session(['customer_id' => $request->customer_id]);
        $customer = Customer::where('customer_id', $request->customer_id)->first();
        $shipping_methods = ShippingMethod::all();
        $shipping_method_settings = CustomerShippingMethod::where('customer_id', $request->customer_id)
                                    ->orderBy('shipping_method_id', 'asc')
                                    ->get();
        return view('customer.shipping_method_setting_index')->with([
            'customer' => $customer,
            'shipping_methods' => $shipping_methods,
            'shipping_method_settings' => $shipping_method_settings,
        ]);
    }

    public function shipping_method_setting_update(Request $request)
    {

        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // パラメータがない=全ての設定を削除
        if (!$request->has('fare_unit_price')) {
            CustomerShippingMethod::where('customer_id', session('customer_id'))->delete();
        }
        // パラメータがあれば更新処理を実施
        if ($request->has('fare_unit_price')) {
            foreach($request->fare_unit_price as $key => $value) {
                // スプリットしてshipping_method_idを取得
                $split_key = explode('-', $key); 
                // 追加の場合は、設定を追加
                if ($split_key[5] == 'add'){
                    $param = [
                        'customer_id' => session('customer_id'),
                        'shipping_method_id' => $split_key[0],
                        'fare_unit_price' => $request->fare_unit_price[$key],
                        'fare_expense' => $request->fare_expense[$key],
                        'shipping_method_note' => $request->shipping_method_note[$key],
                        'created_at' => $nowDate,
                        'updated_at' => $nowDate,
                    ];
                    // レコード追加
                    CustomerShippingMethod::insert($param);
                }
                // 既存の設定は内容を更新
                if ($split_key[5] == 'kizon'){
                    $customer_shipping_method = CustomerShippingMethod::find($split_key[4]);
                    $customer_shipping_method->fare_unit_price = $request->fare_unit_price[$key];
                    $customer_shipping_method->fare_expense = $request->fare_expense[$key];
                    $customer_shipping_method->shipping_method_note = $request->shipping_method_note[$key];
                    $customer_shipping_method->save();
                } 
                // 設定を削除
                if ($split_key[5] == 'del'){
                    CustomerShippingMethod::where('customer_shipping_method_id', $split_key[4])->delete();
                } 
            }
        }
        return back();
    }
}
