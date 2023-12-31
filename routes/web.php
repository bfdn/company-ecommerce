<?php

// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Admin\AjaxController;
// use App\Http\Controllers\Admin\ArticleController;
// use App\Http\Controllers\Admin\Auth\AuthController;
// use App\Http\Controllers\Admin\BlogCategoryController;
// use App\Http\Controllers\Admin\BrandController;
// use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\LanguageController;
// use App\Http\Controllers\Admin\LogController;
// use App\Http\Controllers\Admin\SettingsController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\SongsController;
// use App\Http\Controllers\Admin\RoleController;
// use App\Http\Controllers\Admin\PermissionController;
// use App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Mail\QueueSendMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('front.index');
// })->name("home");


// Route::get('/', [HomeController::class, 'index'])->name('index');

// Route::prefix('admin')->as('front.')->group(function () {});

Route::get('queue', function () {
    // \App\Jobs\LogJob::dispatch('bilalfiddan@gmail.com')->onQueue("high");
    // \App\Jobs\LogJob::dispatch('onur@gmail.com')->onQueue("medium");
    // \App\Jobs\LogJob::dispatch('nese@gmail.com')->onQueue("high");
    // \App\Jobs\LogJob::dispatch('busra@gmail.com')->onQueue("medium");
    // \App\Jobs\LogJob::dispatch('yenibursra@gmail.com');

    $user = User::find(2);
    // \App\Jobs\MailSendJob::dispatch($user)->onQueue()->delay(now()->addSeconds(20)); // 20 saniye beklet;
    // \App\Jobs\MailSendJob::dispatch($user)->delay(now()->addSeconds(20)); // 20 saniye beklet;
    \App\Jobs\MailSendJob::dispatch($user); // 20 saniye beklet;

    // Mail::to($user->email)->send(new QueueSendMail($user));

    dd("tamamlandı");
});




Route::get('/', function () {
    return redirect(app()->getLocale());
});

require_once('admin.php');




Route::as('front.')->group(function () {
    //Route::get('/', [HomeController::class, 'index'])->name('index');
    // Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('show');
    // Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::prefix("{locale}")->middleware(["lang", "defaultlocale"])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        /** ÜYELİK İŞLEMLERİ **/
        Route::get(__('route.register'), [AuthController::class, "showRegister"])->name("register");
        Route::post(__('route.register'), [AuthController::class, "register"]);
        Route::get(__('route.login'), [AuthController::class, "showLoginUser"])->name("login");
        Route::post(__('route.login'), [AuthController::class, "loginUser"]);
        Route::get("/auth/verify/{token}", [AuthController::class, "verify"])->name("verify-token");

        /** ŞİFRE SIFIRLAMA **/
        Route::get(__('route.reset_password'), [AuthController::class, "showPasswordReset"])->name("passwordReset");
        Route::post(__('route.reset_password'), [AuthController::class, "sendPasswordReset"]);
        Route::get(__('route.reset_password') . "/{token}", [AuthController::class, "showPasswordResetConfirm"])->name("passwordResetToken");
        Route::post(__('route.reset_password') . "/{token}", [AuthController::class, "passwordReset"]);


        /** SEPET İŞLEMLERİ **/
        Route::get(__('route.cart'), [CartController::class, "cartList"])->name("cartList");
        Route::get(__('route.cart') . "/bilgi", [CartController::class, "cartInfo"])->name("cartInfo");
        Route::post(__('route.cart') . "/bilgi-gonder", [CartController::class, "cartInfoSend"])->name("cartInfoSend");
        // Route::match(['get', 'post'], __('route.cart') . "/bilgi", [CartController::class, "cartInfo"])->name("cartInfo");
        // Route::get(__('route.cart')."/odeme", [CartController::class, "cartList"])->name("cartList");
        Route::post(__('route.cart') . "/" . __('route.add'), [CartController::class, "addToCart"])->name("addToCart");
        Route::post(__('route.cart') . "/" . "arttir", [CartController::class, "incCount"])->name("cart.incCount");
        Route::post(__('route.cart') . "/" . "azalt", [CartController::class, "decCount"])->name("cart.decCount");
        Route::post(__('route.cart') . "/" . "sil", [CartController::class, "removeFromCart"])->name("cart.removeFromCart");

        Route::get('odeme', [CheckoutController::class, "checkout"])->name("checkout");
        // Route::get('odeme/form', [CheckoutController::class, "checkoutForm"])->name("checkoutForm");
        // Route::get('odeme/sonuc', [CheckoutController::class, "checkoutResult"])->name("checkout.result");
        Route::match(['get', 'post'], 'odeme/sonuc', [CheckoutController::class, "checkoutResult"])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name("checkout.result");



        /** User Profile **/
        Route::middleware(['auth'])->group(function () {
            Route::get('profil', [ProfileController::class, "index"])->name('profile');
            Route::get('profil/siparisler', [ProfileController::class, "orders"])->name('profile.orders');
            Route::get('profil/siparis/{order:order_no}', [ProfileController::class, "order_detail"])->name('profile.orders.detail')->whereNumber('order');
            Route::get('profil/ayarlar', [ProfileController::class, "settings"])->name('profile.settings');
            Route::post('profil/ayar-guncelle', [ProfileController::class, "settingsUpdate"])->name('profile.settings-update');
            Route::post('profil/sifre-guncelle', [ProfileController::class, "passwordUpdate"])->name('profile.password-update');
        });




        /** PRODUCT - ÜRÜNLER **/
        Route::get(__('route.category') . "/{category:slug}", [HomeController::class, "categoryProductList"])->name('categoryProductList')->where('category', '(.*)?');
        Route::get(__('route.product') . "/{product:slug}", [HomeController::class, "productDetail"])->name('productDetail');
        Route::get(__('menu.search'), [HomeController::class, "productSearch"])->name('productSearch');


        /** BLOG **/
        Route::get("/" . __('route.blog'), [HomeController::class, 'blogList'])->name('blog');
        Route::get("/" . __('route.blog') . "/{article:slug}", [HomeController::class, "blogDetail"])->name('blogDetail');
        // Route::get("/" . __('route.blog') . "/{slug}", [HomeController::class, "blogDetail"])->name('blogDetail');
        Route::get(__('route.blog') . "/" . __('route.category') . "/{category:slug}", [HomeController::class, "blogCategoryList"])->name('blogCategoryList');
        // Route::get("/blog/{articles:slug}", [ArticleController::class, "blogDetail"]);
        Route::get(__('route.blog') . "-" . __('menu.search'), [HomeController::class, "blogSearch"])->name('blogSearch');

        /** CONTACT - İLETİŞİM **/
        Route::get(__('route.contact'), [HomeController::class, 'contactPage'])->name('contact');
    })->where(['locale' => '[a-zA-z{2}]']);
});
