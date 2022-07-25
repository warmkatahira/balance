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
        Schema::create('labor_costs', function (Blueprint $table) {
            $table->unsignedInteger('labor_cost_id')->primary();
            $table->unsignedInteger('base_id');
            $table->string('labor_cost_name');
            $table->unsignedInteger('hourly_wage');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('base_id')->references('base_id')->on('bases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labor_costs');
    }
};
