<?php

namespace App\Observers;

use App\Models\BlogCategory;
use App\Traits\Loggable;

class BlogCategoryObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Role::class;
    }

    /**
     * Handle the BlogCategory "created" event.
     */
    public function created(BlogCategory $blogCategory): void
    {
        $this->log('create', $blogCategory->id, $blogCategory->toArray(), $this->model);
    }

    /**
     * Handle the BlogCategory "updated" event.
     */
    public function updated(BlogCategory $blogCategory): void
    {
        $this->updateLog($blogCategory, $this->model);
    }

    /**
     * Handle the BlogCategory "deleted" event.
     */
    public function deleted(BlogCategory $blogCategory): void
    {
        $this->log('delete', $blogCategory->id, $blogCategory->toArray(), $this->model);
    }

    /**
     * Handle the BlogCategory "restored" event.
     */
    public function restored(BlogCategory $blogCategory): void
    {
        // $this->log('restore', $blogCategory->id, $blogCategory->toArray(), $this->model);
    }

    /**
     * Handle the BlogCategory "force deleted" event.
     */
    public function forceDeleted(BlogCategory $blogCategory): void
    {
        // $this->log('force delete', $blogCategory->id, $blogCategory->toArray(), $this->model);
    }
}
