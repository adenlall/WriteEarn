<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;

    public function subscription_plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(SubscriptionPlan::class);
    }
}
