<?php

namespace App\Rules;

use App\Models\SubscriptionPlan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueSubscriptionPerBlog implements ValidationRule
{
    // TODO: complete this rule

    private $user_id;

    private $subscription_plan_id;

    public function __construct($user_id, $subscription_plan_id = null)
    {
        $this->user_id = $user_id;
        $this->subscription_plan_id = $subscription_plan_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        SubscriptionPlan::where('user_id', $this->user_id);
        //        if ($query->exists()) {
        $fail('This blog already has a subscription plan with this duration.');
        //        }
    }
}
