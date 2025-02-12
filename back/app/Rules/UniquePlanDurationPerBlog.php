<?php

namespace App\Rules;

use App\Models\SubscriptionPlan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniquePlanDurationPerBlog implements ValidationRule
{
    private $blog_id;

    private $subscription_plan_id;

    public function __construct($blog_id, $subscription_plan_id = null)
    {
        $this->blog_id = $blog_id;
        $this->subscription_plan_id = $subscription_plan_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = SubscriptionPlan::where('blog_id', $this->blog_id)
            ->where('duration', $value);
        if ($this->subscription_plan_id) {
            $query->where('id', '!=', $this->subscription_plan_id);
        }
        if ($query->exists()) {
            $fail('This blog already has a subscription plan with this duration.');
        }
    }
}
