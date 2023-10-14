<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogCategoryPolicy
{
    // ability gelen isteğin tipini verir, nereye erişmeye çalıştığını
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin == 1) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogCategory $blogCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $user->id === $blogCategory->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->id === $blogCategory->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogCategory $blogCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogCategory $blogCategory): bool
    {
        //
    }
}
