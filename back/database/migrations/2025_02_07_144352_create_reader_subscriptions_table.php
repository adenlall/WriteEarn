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
        Schema::create('reader_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('reader_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('plan_id')
                  ->references('id')
                  ->on('subscription_plans')
                  ->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['active', 'canceled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reader_subscriptions');
    }
};
