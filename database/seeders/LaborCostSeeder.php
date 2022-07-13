<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaborCost;

class LaborCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LaborCost::create([
            'labor_cost_id' => 1,
            'labor_cost_category' => '正社員',
            'hourly_wage' => 2000,
        ]);
        LaborCost::create([
            'labor_cost_id' => 2,
            'labor_cost_category' => 'パート',
            'hourly_wage' => 1000,
        ]);
        LaborCost::create([
            'labor_cost_id' => 3,
            'labor_cost_category' => '派遣',
            'hourly_wage' => 1500,
        ]);
    }
}
