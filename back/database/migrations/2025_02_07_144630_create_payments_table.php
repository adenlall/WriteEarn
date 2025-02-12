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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_subscription_id');
            $table->foreign('reader_subscription_id')
                ->references('id')
                ->on('reader_subscriptions')
                ->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->decimal('platform_fee', 8, 2);
            $table->decimal('publisher_earning', 8, 2);
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
