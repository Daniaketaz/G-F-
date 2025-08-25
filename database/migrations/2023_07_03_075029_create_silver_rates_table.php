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
        Schema::create('silver_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('silver_id')->references('id')->on('silver_products')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('silver_rates');
    }
};
