<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('basket_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basket_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('price')->default(0);
            $table->boolean('is_tour')->default(false);
            $table->integer('ext_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_item');
    }
};
