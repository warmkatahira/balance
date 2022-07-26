<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Carbon\Carbon;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shipping_methods = ShippingMethod::all();
        return view('shipping_method.index')->with([
            'shipping_methods' => $shipping_methods,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'shipping_company' => $request->shipping_company,
            'shipping_method' => $request->shipping_method,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        ShippingMethod::insert($param);
        return back();
    }
}
