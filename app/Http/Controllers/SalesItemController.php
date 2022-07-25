<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesItem;
use Carbon\Carbon;

class SalesItemController extends Controller
{
    public function index()
    {
        $sales_items = SalesItem::all();
        return view('sales_item.index')->with([
            'sales_items' => $sales_items,
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'sales_item_name' => $request->sales_item_name,
            'sales_item_note' => $request->sales_item_note,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        SalesItem::insert($param);
        return back();
    }
}
