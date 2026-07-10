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
        Schema::create('main_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_fr')->nullable();
            $table->string('name_es')->nullable();
            $table->text('description')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->string('image')->nullable();
            $table->string('position')->nullable();
            $table->string('sort');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_banners');
    }
};
