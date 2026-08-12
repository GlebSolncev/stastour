<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tours', 'bokun_id')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->unsignedBigInteger('bokun_id')
                    ->nullable()
                    ->unique()
                    ->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tours', 'bokun_id')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->dropUnique(['bokun_id']);
                $table->dropColumn('bokun_id');
            });
        }
    }
};
