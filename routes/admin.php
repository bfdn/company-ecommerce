<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;


use Illuminate\Support\Facades\Route;

/***** ADMIN ROUTES *****/

// Admin Login
Route::get("admin/login", [AuthController::class, "showLoginAdmin"])->name("login");
Route::post("admin/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout");


// Filemanager
Route::group(['prefix' => 'admin/filemanager', 'middleware' => ['web', 'auth', 'isAdmin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('admin')->as('admin.')->middleware(['auth', 'isAdmin'])->group(function () {


    // Route::group(['prefix' => 'filemanager'], function () {
    // \UniSharp\LaravelFilemanager\Lfm::routes();
    // });


    // Admin
    Route::get('/', [AdminController::class, 'index'])->name('index');
    // Route::get('/', function () {
    // dd("asdasdasdas");
    // });

    // Settings
    // Route::resource("settings", SettingsController::class);
    Route::prefix("settings")->as('settings.')->group(function () {
        Route::get("/", [SettingsController::class, 'index'])->name("index");
        Route::post("/", [SettingsController::class, "update"])->name("update");
        // Route::post("/", [SettingsController::class, "update"]);
    });


    // Users
    // Route::resource("user", UserController::class)->except(['show']);
    Route::resource("user", UserController::class)->except(['show']);
    // Route::match(['put','patch'],"/",[UserController::class,'statusChange']);
    // Route::patch('user/status/{user:id}', [UserController::class, 'statusChange'])->name('user.statusChange');
    Route::patch('user/status/{user:id}', [UserController::class, 'statusChange'])->name('user.statusChange');


    // Rol Yönetimi
    Route::resource("role", RoleController::class)->except(['show']);
    // Route::patch('role/status/{role:id}', [RoleController::class, 'statusChange'])->name('role.statusChange');
    // Route::post("role/ajax", [RoleController::class, "ajax"])->name("role.ajax");

    // Ajax Controller
    Route::prefix("ajax")->as('ajax.')->group(function () {
        Route::post("/getRoles", [AjaxController::class, "getRoles"])->name("getRoles"); // get Roles
    });
    // İzin Yönetimi
    Route::resource("permission", PermissionController::class)->except(['show']);

    // Dil Yönetimi
    Route::resource("language", LanguageController::class)->except(['show']);
    Route::patch('language/status/{language:id}', [LanguageController::class, 'statusChange'])->name('language.statusChange');

    // Logs
    Route::get('logs-db', [LogController::class, 'index'])->name("dbLogs");
    Route::get('logs-db/{id}', [LogController::class, 'getLog'])->name("dblogs.getLog")->whereNumber("id");


    /** Eticaret Kısmı */
    // Marka Yönetimi
    Route::resource("brand", BrandController::class)->except(['show']);
    Route::patch('brand/status/{brand:id}', [BrandController::class, 'statusChange'])->name('brand.statusChange');
    // Kategori
    // Route::resource("category", CategoryController::class)->except(['show']);
    Route::resource("category", CategoryController::class);
    Route::patch('category/status/{category:id}', [CategoryController::class, 'statusChange'])->name('category.statusChange');
    // Ürünler
    Route::resource("product", ProductController::class)->except(['show']);
    Route::patch('product/status/{product:id}', [ProductController::class, 'statusChange'])->name('product.statusChange');
    Route::patch('product/popular/{product:id}', [ProductController::class, 'popularChange'])->name('product.popularChange');
    // Siparişler
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    // Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order:id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order:id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::match(['put', 'patch'], 'orders/{order:id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order:id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('orders/status/{order:id}', [OrderController::class, 'statusChange'])->name('orders.statusChange');



    /** Blog Yönetimi */
    // Blog Kategori
    Route::resource("blog-category", BlogCategoryController::class)->except(['show']);
    // Route::resource("blog-category", BlogCategoryController::class)->except(['show'])->scoped(['blog_category' => 'id']);
    // Route::resource("blog-category", BlogCategoryController::class, [
    //     'bindingFields' => [
    //         'blog_category' => 'id'
    //     ]
    // ])->except(['show']);
    Route::patch('blog-category/status/{blog_category:id}', [BlogCategoryController::class, 'statusChange'])->name('blog-category.statusChange');
    // Yazılar
    Route::resource("article", ArticleController::class)->except(['show']);
    Route::patch('article/status/{article:id}', [ArticleController::class, 'statusChange'])->name('article.statusChange');
});
