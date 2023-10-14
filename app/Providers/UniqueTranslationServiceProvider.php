<?php

namespace App\Providers;

use CodeZero\UniqueTranslation\UniqueTranslationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class UniqueTranslationServiceProvider extends ServiceProvider
{
    // use Validator;

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
        // dd("asdasda");
        Validator::extend('unique_translation', UniqueTranslationValidator::class . '@validate');
    }
}
