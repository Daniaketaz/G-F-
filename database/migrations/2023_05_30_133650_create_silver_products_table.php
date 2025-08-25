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
        Schema::create('silver_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->foreignId('jewelry-categories-id')->references('id')->on('jewelry_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('photo')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('weight',20)->nullable();
            $table->decimal('weight_difference')->default(0.5);
            $table->decimal('accessories_price',20)->nullable();
            $table->decimal('formulation_price',20)->nullable();
            $table->decimal('final_price',20)->nullable();
            $table->bigInteger('views')->nullable();
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
        Schema::dropIfExists('silvers');
    }
};
