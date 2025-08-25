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
        Schema::create('gold_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gold_id')->references('id')->on('gold_products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('number')->default(0);
            $table->double('rate')->default(0);
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
        Schema::dropIfExists('gold_rates');
    }
};
