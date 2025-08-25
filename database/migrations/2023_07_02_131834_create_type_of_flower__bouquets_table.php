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
        Schema::create('type_of_flower__bouquets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Bouquet_id')->constrained('Bouquets');
            $table->foreignId('TypeOfFlower_id')->constrained('type_of_flowers');
            $table->integer('numOfFlower');
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
        Schema::dropIfExists('type_of_flower__bouquets');
    }
};
