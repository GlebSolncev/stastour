<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('status')->default('draft')->index();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->unsignedBigInteger('bokun_booking_id')->nullable()->index();
            $table->string('bokun_confirmation_code')->nullable()->unique();
            $table->string('bokun_status')->nullable();
            $table->json('bokun_payload')->nullable();
            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn([
                'status', 'amount', 'currency', 'bokun_booking_id',
                'bokun_confirmation_code', 'bokun_status', 'bokun_payload',
                'stripe_session_id', 'stripe_payment_intent_id', 'paid_at',
            ]);
        });
    }
};
