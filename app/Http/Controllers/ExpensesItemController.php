<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesItem;
use Carbon\Carbon;

class ExpensesItemController extends Controller
{
    public function index()
    {
        $expenses_items = ExpensesItem::all();
        return view('expenses_item.index')->with([
            'expenses_items' => $expenses_items,
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'expenses_item_name' => $request->expenses_item_name,
            'expenses_item_note' => $request->expenses_item_note,
            'expenses_item_category' => $request->expenses_item_category,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        ExpensesItem::insert($param);
        return redirect()->route('expenses_item.index');
    }

    public function delete(Request $request)
    {
        // 荷役を削除
        ExpensesItem::where('expenses_item_id', $request->expenses_item_id)->delete();
        return back();
    }
}
