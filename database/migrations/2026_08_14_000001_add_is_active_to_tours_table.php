<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tours', 'is_active')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->index()->after('bokun_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tours', 'is_active')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
                $table->dropColumn('is_active');
            });
        }
    }
};
