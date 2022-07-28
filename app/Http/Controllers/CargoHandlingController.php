<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CargoHandling;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CargoHandlingController extends Controller
{
    public function index()
    {
        $cargo_handlings = CargoHandling::all();
        return view('cargo_handling.index')->with([
            'cargo_handlings' => $cargo_handlings,
        ]);
    }

    public function register(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        $param = [
            'cargo_handling_name' => $request->cargo_handling_name,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        CargoHandling::insert($param);
        return back();
    }

    public function delete(Request $request)
    {
        // 荷役を削除
        CargoHandling::where('cargo_handling_id', $request->cargo_handling_id)->delete();
        return back();
    }
}
