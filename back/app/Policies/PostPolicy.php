<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;

class PostPolicy
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
    public function view(User $user, Post $post, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $blog->id === $post->blog_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $blog->user_id === $user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $blog->id === $post->blog_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post, Blog $blog): bool
    {
        return $user->admin() || ($user->publisher() && $user->id === $blog->user_id && $blog->id === $post->blog_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
