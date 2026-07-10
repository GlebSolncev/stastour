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
        Schema::table('main_banners', function (Blueprint $table) {
            $table->string('url')->nullable();
            $table->string('button')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_banners', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('button');
        });
    }
};
