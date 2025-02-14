<?php

namespace App\Policies;

use App\Models\ReaderSubscription;
use App\Models\User;

class ReaderSubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ReaderSubscription $readerSubscription): bool
    {
        return $user->admin() || ($user->id === $readerSubscription->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->admin() || $user->reader();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return true;
    }
}
