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
        Schema::create('balance_cargo_handlings', function (Blueprint $table) {
            $table->bigIncrements('balance_cargo_handling_id');
            $table->unsignedBigInteger('balance_id');
            $table->string('cargo_handling_name');
            $table->unsignedInteger('operation_quantity');
            $table->unsignedInteger('cargo_handling_unit_price');
            $table->unsignedInteger('cargo_handling_amount');
            $table->string('cargo_handling_note')->nullable();
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
        Schema::dropIfExists('balance_cargo_handlings');
    }
};
