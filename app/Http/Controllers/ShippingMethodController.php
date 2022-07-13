<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;

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
}
