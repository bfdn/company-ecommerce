<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BlogCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;


class HomeController extends Controller
{
    public function index()
    {
        $popularCategories = Category::query()->with('ancestors', fn ($query) => $query->where(['status' => 1])->orderBy('id', 'asc'))->where(['popular' => 1, 'status' => 1])->limit(6)->orderBy('id', 'asc')->get();
        $popularProducts = Product::query()->where(['popular' => 1, 'status' => 1])->limit(5)->orderBy('id', 'asc')->get();
        $lastProducts = Product::query()->where(['status' => 1])->limit(6)->orderBy('id', 'desc')->get();

        $articles = Article::query()->with(["category:id,name", "user:id,name"])->active()->orderByDesc('id')->limit(3)->get();

        return view('front.index', ['articles' => $articles, 'popularCategories' => $popularCategories, 'popularProducts' => $popularProducts, 'lastProducts' => $lastProducts]);
    }

    /* CATEGORY - PRODUCT - ÜRÜNLER */
    public function categoryProductList(Request $request, string $locale, Category $category)
    {
        $sort = $request->sort;
        $products = $category->recursiveProducts()
            ->when($request->min, function ($query) use ($request) {
                $query->where('price', '>', $request->min);
            })
            ->when($request->max, function ($query) use ($request) {
                $query->where('price', '<', $request->max);
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'azalanfiyat' => $query->orderBy('price', 'desc'),
                    'artanfiyat' => $query->orderBy('price', 'asc'),
                    default => $query->orderBy('id', 'desc'),
                };
            })
            ->orderBy('id', 'DESC')
            ->paginate(1)->withQueryString();


        if ($sort && $request->ajax()) {
            return [
                'link' => $request->fullUrlWithQuery(['sort' => $sort]),
                'data' => view('front.product-wrapper', ['products' => $products])->render()
            ];
        }

        $parentCategories = $category->ancestors()->orderBy('id', 'ASC')->get();
        $childrenCategories = $category->children()->get();



        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
        ];
        $catSlug = "";
        foreach ($parentCategories as $parentCategory) {
            $catSlug .= $parentCategory->slug . "/";
            array_push($breadcrumbs, ['name' => $parentCategory->name, 'link' => route('front.categoryProductList', ['category' => $catSlug])]);
        }
        $breadcrumbs[] = [
            "name" => $category->name,
            "link" => "#"
        ];


        $page_title = $category->name . ' | ' . config('app.name');
        return view('front.product-list', ['page_title' => $page_title, 'breadcrumbs' => $breadcrumbs, 'products' => $products, 'childrenCategories' => $childrenCategories, 'category' => $category]);
    }

    public function productDetail(Request $request, string $locale, Product $product)
    {
        $category = $product->categories()->first();
        $parentCategories = $category->ancestorsAndSelf()->orderBy('id', 'asc')->get();

        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
        ];
        $catSlug = "";
        foreach ($parentCategories as $parentCategory) {
            $catSlug .= $parentCategory->slug . "/";
            array_push($breadcrumbs, ['name' => $parentCategory->name, 'link' => route('front.categoryProductList', ['category' => $catSlug])]);
        }
        $breadcrumbs[] = [
            "name" => $product->name,
            "link" => "#"
        ];

        $page_title = $product->name . ' | ' . config('app.name');
        return view('front.product-detail', ['page_title' => $page_title, 'breadcrumbs' => $breadcrumbs, 'product' => $product, 'category' => $category, 'catSlug' => $catSlug]);
    }

    public function productSearch(Request $request, string $locale)
    {
        $searchText = $request->pq;
        $sort = $request->sort;
        $products = Product::query()
            ->when($searchText, function ($query) use ($locale, $searchText) {
                $query->where(function ($query) use ($locale, $searchText) {
                    $query->where("name->{$locale}", "like", "%$searchText%")
                        ->orWhere("slug->{$locale}", "like", "%$searchText%")
                        ->orWhere("content->{$locale}", "like", "%$searchText%");
                });
            })
            ->when($request->min, function ($query) use ($request) {
                $query->where('price', '>', $request->min);
            })
            ->when($request->max, function ($query) use ($request) {
                $query->where('price', '<', $request->max);
            })
            ->when($request->brand, function ($query) use ($request) {
                $query->where('brand_id', $request->brand);
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'azalanfiyat' => $query->orderBy('price', 'desc'),
                    'artanfiyat' => $query->orderBy('price', 'asc'),
                    default => $query->orderBy('id', 'desc'),
                };
            })
            ->active()
            ->orderBy('id', 'DESC')
            ->paginate(1)->withQueryString();

        $brands = Brand::query()->active()->get();

        if ($request->ajax()) {
            return [
                'link' => $request->fullUrlWithQuery(['sort' => $sort]),
                'data' => view('front.product-wrapper', ['products' => $products])->render()
            ];
        }



        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.search'),
                "link" => "#"
            ]
        ];
        $page_title = "$searchText " . mb_strtolower(__('front.search_result')) . ' | ' . config('app.name');
        return view('front.product-search', ['page_title' => $page_title, 'breadcrumbs' => $breadcrumbs, 'products' => $products, 'brands' => $brands]);
    }



    /* BLOG */
    public function blogDetail(Request $request, string $locale, Article $article)
    {
        $blogCategories = BlogCategory::query()->with(['articles' => fn ($query) => $query->active()])->active()->get();
        $lastArticles = Article::query()->with(["category:id,name"])->active()->orderByDesc('id')->limit(3)->get();
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => $article->category->name,
                "link" => route('front.blogCategoryList', ['category' => $article->category->slug])
            ],
            [
                "name" => $article->name,
                "link" => "#"
            ]
        ];

        return view('front.blog-detail', ['item' => $article, 'blogCategories' => $blogCategories, 'lastArticles' => $lastArticles, 'breadcrumbs' => $breadcrumbs]);
    }

    public function blogCategoryList(Request $request, string $locale, BlogCategory $category)
    {
        $locale = config('app.locale');

        $blogCategories = BlogCategory::query()->with(['articles' => fn ($query) => $query->active()])->active()->get();
        $lastArticles = Article::query()->with(["category:id,name"])->active()->orderByDesc('id')->limit(3)->get();
        // $articles = Article::query()
        $articles = $category->articles()
            ->withWhereHas('user', fn ($query) => $query->select("id", "name", "email")->active())
            ->withWhereHas('category', fn ($query) => $query->active())
            ->where('blog_category_id', $category->id)
            ->active()
            ->orderByDesc('id')
            ->paginate(10)->withQueryString();

        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('menu.blog'),
                "link" => route('front.blog')
            ],
            [
                "name" => $category->name,
                "link" => "#"
            ]
        ];
        $page_title = $category->name . ' | ' . config('app.name');
        return view('front.blog-list', ['item' => $category, 'blogCategories' => $blogCategories, 'lastArticles' => $lastArticles, 'breadcrumbs' => $breadcrumbs, 'articles' => $articles, 'page_title' => $page_title]);
    }

    public function blogList(Request $request, $locale)
    {
        $locale = config('app.locale');

        $blogCategories = Cache::remember("blogCategories", 3600, function () {
            return BlogCategory::query()->with(['articles' => fn ($query) => $query->active()])->active()->get();
        });

        $lastArticles = Article::query()->with(["category:id,name"])->active()->orderByDesc('id')->limit(3)->get();

        $articles = Article::query()
            ->withWhereHas('user', fn ($query) => $query->select("id", "name", "email")->active())
            ->withWhereHas('category', fn ($query) => $query->active())
            ->active()
            ->orderByDesc('id')
            ->paginate(10)->withQueryString();

        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('menu.blog'),
                "link" => "#"
            ],
        ];
        $page_title = __('menu.blog') . ' | ' . config('app.name');
        return view('front.blog-list', ['blogCategories' => $blogCategories, 'lastArticles' => $lastArticles, 'breadcrumbs' => $breadcrumbs, 'articles' => $articles, 'page_title' => $page_title]);
    }

    public function blogSearch(Request $request, $locale)
    {
        $locale = config('app.locale');
        $searchText = $request->q;

        $blogCategories = Cache::remember("blogCategories", 3600, function () {
            return BlogCategory::query()->with(['articles' => fn ($query) => $query->active()])->active()->get();
        });
        $lastArticles = Article::query()->with(["category:id,name"])->active()->orderByDesc('id')->limit(3)->get();

        $articles = Article::with(['category', 'user'])->where(function ($query) {
            $query->active()
                ->whereHas('category', function ($query) {
                    $query->active();
                })->whereHas('user', function ($query) {
                    $query->active();
                });
        })->where(function ($query) use ($searchText, $locale) {
            $query->where(function ($query) use ($searchText, $locale) {
                // $query
                //     ->search("name->{$locale}", $searchText)
                //     ->search("slug->{$locale}", $searchText)
                //     ->search("content->{$locale}", $searchText);
                $query->where("name->{$locale}", "LIKE", "%$searchText%")
                    ->orWhere("slug->{$locale}", "LIKE", "%$searchText%")
                    ->orWhere("content->{$locale}", "LIKE", "%$searchText%");
            })->orWhereHas('category', function ($query) use ($searchText, $locale) {
                $query->where("name->{$locale}", "LIKE", "%$searchText%")
                    ->orWhere("slug->{$locale}", "LIKE", "%$searchText%")
                    ->orWhere("content->{$locale}", "LIKE", "%$searchText%");
            })->orWhereHas('user', function ($query) use ($searchText) {
                $query->where('name', 'like', "%$searchText%");
            });
        })
            ->orderByDesc('id')
            ->paginate(10)->withQueryString();

        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('menu.blog'),
                "link" => route('front.blog')
            ],
            [
                "name" => __('front.search'),
                "link" => "#"
            ],
        ];
        $page_title = "$searchText " . mb_strtolower(__('front.search_result')) . ' | ' . config('app.name');
        return view('front.blog-list', ['blogCategories' => $blogCategories, 'lastArticles' => $lastArticles, 'breadcrumbs' => $breadcrumbs, 'articles' => $articles, 'page_title' => $page_title, 'searchText' => $searchText]);
    }



    /* CONTACT */
    public function contactPage()
    {
    }


    /*****************************/
}
