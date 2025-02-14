<?php

namespace App\Rules;

use App\Models\ReaderSubscription;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueSubscriptionPerBlog implements ValidationRule
{
    private int $user_id;

    public function __construct($user)
    {
        $this->user_id = $user->id;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = ReaderSubscription::where('user_id', $this->user_id)
            ->where('blog_id', $value)
            ->exists();
        if ($exists) {
            $fail('A subscription with this blog and plan already exists.');
        }
    }
}
