<?php

namespace App\Observers;

use App\Models\Product;
use App\Traits\Loggable;

class ProductObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Product::class;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->log('create', $product->id, $product->toArray(), $this->model);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->updateLog($product, $this->model);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->log('delete', $product->id, $product->toArray(), $this->model);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        // $this->log('restore', $product->id, $product->toArray(), $this->model);
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        // $this->log('force delete', $product->id, $product->toArray(), $this->model);
    }
}
