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
        Schema::create('balance_fares', function (Blueprint $table) {
            $table->bigIncrements('balance_fare_id');
            $table->unsignedBigInteger('balance_id');
            $table->string('fare_balance_category');
            $table->string('shipping_method_name');
            $table->unsignedInteger('box_quantity');
            $table->unsignedInteger('fare_unit_price');
            $table->unsignedInteger('fare_amount');
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
        Schema::dropIfExists('balance_fares');
    }
};
