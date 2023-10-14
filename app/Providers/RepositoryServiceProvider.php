<?php

namespace App\Providers;

use App\Services\Interfaces\BlogInterface;
use App\Services\Repositories\BlogRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // app()->bind(BlogInterface::class, BlogRepository::class);
        $this->app->bind(BlogInterface::class, BlogRepository::class);
        // $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
