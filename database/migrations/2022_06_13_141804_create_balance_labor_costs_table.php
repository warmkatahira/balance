<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_labor_costs', function (Blueprint $table) {
            $table->bigIncrements('balance_labor_costs_id');
            $table->unsignedBigInteger('balance_id');
            $table->string('labor_cost_name');
            $table->float('working_time', 5, 2);
            $table->unsignedinteger('hourly_wage');
            $table->unsignedinteger('labor_costs');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('balance_id')->references('balance_id')->on('balances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_labor_costs');
    }
};
