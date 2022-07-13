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
        Schema::create('monthly_expense_settings', function (Blueprint $table) {
            $table->bigIncrements('monthly_expense_setting_id');
            $table->unsignedInteger('base_id');
            $table->unsignedInteger('setting_date');
            $table->unsignedBigInteger('expense_id');
            $table->unsignedInteger('expense_amount');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('base_id')->references('base_id')->on('bases')->onDelete('cascade');
            $table->foreign('expense_id')->references('expense_id')->on('expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_expense_settings');
    }
};
