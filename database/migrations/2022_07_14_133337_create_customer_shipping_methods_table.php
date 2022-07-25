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
        Schema::create('customer_shipping_method', function (Blueprint $table) {
            $table->bigIncrements('customer_shipping_method_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('shipping_method_id');
            $table->unsignedInteger('fare_unit_price');
            $table->unsignedInteger('fare_expense');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('shipping_method_id')->references('shipping_method_id')->on('shipping_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_shipping_method');
    }
};
