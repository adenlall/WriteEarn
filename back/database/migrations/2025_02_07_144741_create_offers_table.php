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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('coupon')->nullable();
            $table->boolean('public')->default('true');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')
                  ->references('id')
                  ->on('subscription_plans')
                  ->onDelete('cascade');
            $table->decimal('discount', 5, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
