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
        Schema::create('expenses_items', function (Blueprint $table) {
            $table->bigIncrements('expenses_item_id');
            $table->string('expenses_item_name');
            $table->string('expenses_item_note')->nullable();
            $table->string('expenses_item_category');
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
        Schema::dropIfExists('expenses_items');
    }
};
