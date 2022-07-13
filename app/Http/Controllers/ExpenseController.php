<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('expense.index')->with([
            'expenses' => $expenses,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }

    public function register(Request $request)
    {
        $nowDate = new Carbon('now');
        $param = [
            'expense_name' => $request->expense_name,
            'expense_note' => $request->expense_note,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ];
        Expense::insert($param);
        return redirect()->route('expense.index');
    }
}
