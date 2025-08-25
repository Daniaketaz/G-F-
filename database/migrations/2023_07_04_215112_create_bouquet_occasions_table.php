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
        Schema::create('bouquet_occasions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bouquet_id')->constrained('bouquets');
            $table->foreignId('occasion_id')->constrained('occasions');
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
        Schema::dropIfExists('bouquet_occasions');
    }
};
