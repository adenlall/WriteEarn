<?php

namespace App\Rules;

use App\Models\Offer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueOfferPerPlan implements ValidationRule
{
    private int $subscription_plan_id;

    public function __construct($subscription_plan)
    {
        $this->subscription_plan_id = $subscription_plan->id;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Offer::where('subscription_plan_id', $this->subscription_plan_id)
            ->where('coupon', $value)
            ->exists();
        if ($exists) {
            $fail('This subscription plan with this coupon already exists.');
        }
    }
}
