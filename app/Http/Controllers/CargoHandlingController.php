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
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        return view('cargo_handling.index')->with([
            'cargo_handlings' => $cargo_handlings,
            'customers' => $customers,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function register(Request $request)
    {
        //dd($request->cargo_handling_name,$request->cargo_handling_name_add);
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 追加があれば実施
        if ($request->has('cargo_handling_name_add')) {
            for($i = 0; $i < count($request->cargo_handling_name_add); $i++) {
                $param = [
                    'cargo_handling_name' => $request->cargo_handling_name_add[$i],
                    'cargo_handling_note' => $request->cargo_handling_note_add[$i],
                    'created_at' => $nowDate,
                    'updated_at' => $nowDate,
                ];
                CargoHandling::insert($param);
            }
        }
        return back();
    }
}
