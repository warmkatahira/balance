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
        Schema::create('sales_plans', function (Blueprint $table) {
            $table->bigIncrements('sales_plan_id');
            $table->unsignedInteger('base_id');
            $table->unsignedInteger('plan_date');
            $table->unsignedinteger('sales_plan_amount');
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
        Schema::dropIfExists('sales_plans');
    }
};
