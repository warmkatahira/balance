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
        Schema::create('monthly_sales_settings', function (Blueprint $table) {
            $table->bigIncrements('monthly_sales_setting_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('sales_item_id');
            $table->unsignedInteger('sales_amount');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('sales_item_id')->references('sales_item_id')->on('sales_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_sales_settings');
    }
};
