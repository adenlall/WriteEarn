<?php

namespace App\Models;

use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    /** @use HasFactory<OfferFactory> */
    use HasFactory;

    protected $fillable = [
        'coupon', 'public', 'subscription_plan_id', 'discount', 'start_date', 'end_date',
    ];

    public function subscriptionPlan(): BelongsTo
    {
        return $this->BelongsTo(SubscriptionPlan::class);
    }
}
