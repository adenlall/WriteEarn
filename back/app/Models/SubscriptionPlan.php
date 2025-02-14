<?php

namespace App\Models;

use Database\Factories\SubscriptionPlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    /** @use HasFactory<SubscriptionPlanFactory> */
    use HasFactory;

    protected $table = 'subscription_plans';

    protected $fillable = [
        'blog_id', 'price', 'duration', 'discount', 'is_active',
    ];

    public function blog(): BelongsTo
    {
        return $this->BelongsTo(Blog::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function readerSubscriptions(): HasMany
    {
        return $this->hasMany(ReaderSubscription::class);
    }
}
