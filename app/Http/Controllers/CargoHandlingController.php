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
        // 追加があれば実施
        if ($request->has('cargo_handling_name_add')) {
            for($i = 0; $i < count($request->cargo_handling_name_add); $i++) {
                $param = [
                    'cargo_handling_name' => $request->cargo_handling_name_add[$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                CargoHandling::insert($param);
            }
        }
        return back();
    }
}
