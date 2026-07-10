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
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('name_fr', 'name_pt');
            $table->renameColumn('detail_text_fr', 'detail_text_pt');
            $table->renameColumn('preview_text_fr', 'preview_text_pt');
            $table->boolean('is_priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('name_pt', 'name_fr');
            $table->renameColumn('detail_text_pt', 'detail_text_fr');
            $table->renameColumn('preview_text_pt', 'preview_text_fr');
            $table->dropColumn('is_priority');
        });
    }
};
