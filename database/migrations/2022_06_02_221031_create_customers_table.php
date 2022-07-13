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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('customer_name');
            $table->unsignedInteger('control_base_id');
            $table->unsignedInteger('register_user_id');
            $table->unsignedInteger('monthly_storage_fee')->nullable();
            $table->unsignedinteger('working_days')->nullable();
            $table->string('handling_fee_category')->nullable();
            $table->timestamps();
            // 外部キー制約
            $table->foreign('control_base_id')->references('base_id')->on('bases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
