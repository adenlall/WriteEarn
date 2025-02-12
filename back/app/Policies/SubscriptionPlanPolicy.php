<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\SubscriptionPlan;
use App\Models\User;

class SubscriptionPlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SubscriptionPlan $subscriptionPlan, Blog $blog): bool
    {
        return $user->admin() || ($user->id === $blog->user_id && $subscriptionPlan->blog_id === $blog->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SubscriptionPlan $subscriptionPlan, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $subscriptionPlan->blog_id === $blog->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SubscriptionPlan $subscriptionPlan, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $subscriptionPlan->blog_id === $blog->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return false;
    }
}
