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
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_fr')->nullable();
            $table->string('name_es')->nullable();
            $table->string('image')->nullable();
            $table->string('code');
            $table->text('detail_text')->nullable();
            $table->text('detail_text_fr')->nullable();
            $table->text('detail_text_es')->nullable();
            $table->text('preview_text')->nullable();
            $table->text('preview_text_fr')->nullable();
            $table->text('preview_text_es')->nullable();
            $table->boolean('is_big');
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
        Schema::dropIfExists('news');
    }
};
