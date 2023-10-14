<?php

namespace App\Observers;

use App\Models\Brand;
use App\Traits\Loggable;

class BrandObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Brand::class;
    }

    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        $this->log('create', $brand->id, $brand->toArray(), $this->model);
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        $this->updateLog($brand, $this->model);
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        $this->log('delete', $brand->id, $brand->toArray(), $this->model);
    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        // $this->log('restore', $brand->id, $brand->toArray(), $this->model);
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        // $this->log('force delete', $brand->id, $brand->toArray(), $this->model);
    }
}
