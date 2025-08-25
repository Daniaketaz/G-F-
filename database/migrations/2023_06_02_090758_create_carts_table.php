<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->references('id')->on('sessions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('size')->default(1)->nullable();
            $table->decimal('price')->nullable();
            $table->bigInteger('quantity')->default(1)->nullable();
            $table->decimal('total_price')->default(0);
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
        Schema::dropIfExists('carts');
    }
};
