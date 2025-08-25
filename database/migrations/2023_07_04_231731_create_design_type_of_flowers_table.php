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
        Schema::create('design_type_of_flowers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Type_Of_Flower_id')->constrained('type_of_flowers');
            $table->foreignId('design_id')->constrained('designs');
            $table->integer('numberOfFlowers')->default('1');
            $table->double('price');
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
        Schema::dropIfExists('design_type_of_flowers');
    }
};
