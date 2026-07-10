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
        Schema::table('tours', function (Blueprint $table) {
            $table->string('map_file')->nullable();
            $table->string('preview_photo')->nullable();
            $table->string('detail_photo')->nullable();
            $table->string('type_road_tour')->nullable();
            $table->string('label_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('map_file');
            $table->dropColumn('preview_photo');
            $table->dropColumn('detail_photo');
            $table->dropColumn('type_road_tour');
            $table->dropColumn('label_color');
        });
    }
};
