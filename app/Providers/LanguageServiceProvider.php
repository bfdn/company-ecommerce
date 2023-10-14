<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;


class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $activeLangs = Language::query()->where("status", 1)->pluck("short_name")->toArray();
        Config::set("app.langs", $activeLangs);
    }
}
