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
        Schema::create('timeslot', function (Blueprint $table) {
            $table->id();

            $table->boolean('wd_mon')->default(false);
            $table->boolean('wd_tue')->default(false);
            $table->boolean('wd_wed')->default(false);
            $table->boolean('wd_thu')->default(false);
            $table->boolean('wd_fri')->default(false);
            $table->boolean('wd_sat')->default(false);
            $table->boolean('wd_sun')->default(false);

            $table->integer('begin');
            $table->integer('end');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslot');
    }
};
