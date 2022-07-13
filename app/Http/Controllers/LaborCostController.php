<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaborCost;

class LaborCostController extends Controller
{
    public function index()
    {
        $labor_costs = LaborCost::orderBy('labor_cost_id', 'asc')->get();
        return view('labor_cost.index')->with([
            'labor_costs' => $labor_costs,
            'sort_column' => session('sort_column'),
            'direction' => session('direction'),
        ]);
    }
}
