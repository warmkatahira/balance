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
        Schema::create('monthly_expenses_settings', function (Blueprint $table) {
            $table->bigIncrements('monthly_expenses_setting_id');
            $table->unsignedInteger('base_id');
            $table->unsignedInteger('setting_date');
            $table->unsignedBigInteger('expenses_item_id');
            $table->unsignedInteger('expenses_amount');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('base_id')->references('base_id')->on('bases')->onDelete('cascade');
            $table->foreign('expenses_item_id')->references('expenses_item_id')->on('expenses_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_expenses_settings');
    }
};
