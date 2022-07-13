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
        Schema::create('cargo_handling_customer', function (Blueprint $table) {
            $table->bigIncrements('cargo_handling_customer_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('cargo_handling_id');
            $table->unsignedInteger('cargo_handling_unit_price');
            $table->boolean('balance_register_default_disp');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('cargo_handling_id')->references('cargo_handling_id')->on('cargo_handlings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_handling_customer');
    }
};
