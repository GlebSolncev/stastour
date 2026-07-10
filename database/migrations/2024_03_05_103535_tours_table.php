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
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_fr')->nullable();
            $table->string('name_es')->nullable();
            $table->float('price');
            $table->text('preview_text');
            $table->text('preview_text_fr')->nullable();
            $table->text('preview_text_es')->nullable();
            $table->string('code');
            $table->string('type_tour');
            $table->text('description');
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->string('image');
            $table->string('person_count');
            $table->string('duration_of_the_tour');
            $table->string('road');
            $table->string('time_slot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
