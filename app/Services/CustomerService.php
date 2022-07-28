<?php

namespace App\Services;

use App\Models\Base;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerService
{
    public function inputSession($base_id)
    {
        // 現在のURLを取得
        session(['index_url' => url()->full()]);
        // セッションに格納(初期は自拠点を格納)
        session(['base_id' => $base_id]);
        return;
    }

    public function getCustomerAndBase()
    {
        // 拠点の情報を取得
        $bases = Base::all();
        // 指定した拠点の荷主を取得
        $query = Customer::query();
        // 拠点が全拠点以外なら拠点を条件に入れる
        if(session('base_id') != 0){
            $query = $query->where('control_base_id', session('base_id'));
        }
        $customers = $query->orderBy('control_base_id', 'asc')->get();
        return with([
            'bases' => $bases,
            'customers' => $customers,
        ]);
    }
}