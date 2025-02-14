<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\Offer;
use App\Models\SubscriptionPlan;
use App\Models\User;

class OfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Offer $offer, SubscriptionPlan $subscriptionPlan): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Blog $blog, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $blog->id === $subscriptionPlan->blog_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer, Blog $blog, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->admin() || ($user->publisher() && $offer->subscription_plan_id === $subscriptionPlan->id && $user->id === $blog->user_id && $blog->id === $subscriptionPlan->blog_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Offer $offer, Blog $blog, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->admin() || ($user->publisher() && $offer->subscription_plan_id === $subscriptionPlan->id && $user->id === $blog->user_id && $blog->id === $subscriptionPlan->blog_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Offer $offer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Offer $offer): bool
    {
        return true;
    }
}
