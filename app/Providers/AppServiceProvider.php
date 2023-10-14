<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();


        View::composer(['front.*', 'admin.*', 'email.*'], function ($view) {
            $settings = Cache::remember("settings", 1800, fn () => Settings::first());
            $langs = Cache::remember("langs", 3600, fn () => Language::query()->where("status", 1)->orderBy("id", "asc")->get());

            $view->with("settings", $settings)->with("langs", $langs);
        });

        $headerMenuCategories = Cache::remember("headerMenuCategories", 3600, function () {
            return Category::withRecursiveQueryConstraint(function (Builder $query) {
                $query->where('categories.status', 1);
            }, function () {
                return Category::treeOf(function ($query) {
                    $query->whereNull('parent_id')->where('status', 1);
                }, 1)->get()->toTree();
            });
        });



        View::composer(['layouts.front.header'], function ($view) use ($headerMenuCategories) {
            $view->with("headerMenuCategories", $headerMenuCategories);
        });


        // Model Scope Active
        Builder::macro('active', function (string $table = null) {
            return isset($table) ? $this->where($table . ".status", 1) : $this->where('status', 1);
        });


        Builder::macro('search', function ($attributes, string $searchTerm) {
            foreach (Arr::wrap($attributes) as $attribute) {
                $this->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
            }
            return $this;
        });
    }
}
