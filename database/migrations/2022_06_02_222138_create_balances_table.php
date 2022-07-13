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
        Schema::create('balances', function (Blueprint $table) {
            $table->bigIncrements('balance_id');
            $table->unsignedInteger('register_user_id');
            $table->unsignedInteger('balance_base_id');
            $table->date('balance_date');
            $table->unsignedInteger('balance_customer_id');
            $table->integer('storage_fee')->nullable();
            $table->integer('sales')->nullable();
            $table->integer('expenses')->nullable();
            $table->integer('profit')->nullable();
            $table->string('balance_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
};
