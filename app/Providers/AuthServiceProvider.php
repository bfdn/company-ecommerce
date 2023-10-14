<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

// use App\Models\Article;
// use App\Models\BlogCategory;
// use App\Models\Brand;
// use App\Policies\ArticlePolicy;
// use App\Policies\BlogCategoryPolicy;
// use App\Policies\BrandPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        App\Models\Article::class => App\Policies\ArticlePolicy::class,
        App\Models\BlogCategory::class => App\Policies\BlogCategoryPolicy::class,
        App\Models\Brand::class => App\Policies\BrandPolicy::class,
        App\Models\Category::class => App\Policies\CategoryPolicy::class,
        App\Models\Language::class => App\Policies\LanguagePolicy::class,
        App\Models\Product::class => App\Policies\ProductPolicy::class,
    ];

    // protected $policies = [
    //     Post::class => PostPolicy::class,
    // ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //$this->registerPolicies();
    }
}
