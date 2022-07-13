<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\ShippingMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function index()
    {
        $bases = Base::all();
        return view('base.index')->with([
            'bases' => $bases,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }
}
