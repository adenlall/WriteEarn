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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['active', 'holding', 'canceled'])->default('holding');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign(['subscription_plan_id', 'blog_id'])
                ->references(['id', 'blog_id'])
                ->on('subscription_plans')
                ->onDelete('cascade');

            $table->unique(['user_id', 'blog_id']);
            $table->unique(['user_id', 'subscription_plan_id']);

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
