<?php

namespace App\Models;

use Database\Factories\ReaderSubscriptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReaderSubscription extends Model
{
    /** @use HasFactory<ReaderSubscriptionFactory> */
    use HasFactory;

    protected $table = 'reader_subscriptions';

    protected $fillable = [
        'user_id', 'subscription_plan_id', 'blog_id', 'start_date', 'end_date', 'status',
    ];

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
