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
        Schema::create('balance_other_expenses', function (Blueprint $table) {
            $table->bigIncrements('balance_other_expenses_id');
            $table->unsignedBigInteger('balance_id');
            $table->string('other_expenses_name');
            $table->unsignedinteger('other_expenses_amount');
            $table->string('other_expenses_note')->nullable();
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
        Schema::dropIfExists('balance_other_expenses');
    }
};
