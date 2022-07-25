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
        $labor_cost_id_count = 0;
        for($i = 1; $i < 12; $i++){
            $labor_cost_id_count ++;
            LaborCost::create([
                'labor_cost_id' => $labor_cost_id_count,
                'base_id' => $i,
                'labor_cost_name' => '社員',
                'hourly_wage' => 2000,
            ]);
            $labor_cost_id_count ++;
            LaborCost::create([
                'labor_cost_id' => $labor_cost_id_count,
                'base_id' => $i,
                'labor_cost_name' => 'パート',
                'hourly_wage' => 1000,
            ]);
            $labor_cost_id_count ++;
            LaborCost::create([
                'labor_cost_id' => $labor_cost_id_count,
                'base_id' => $i,
                'labor_cost_name' => '派遣',
                'hourly_wage' => 1500,
            ]);
        }
    }
}
