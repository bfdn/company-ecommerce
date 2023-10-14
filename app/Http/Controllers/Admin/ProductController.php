<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\TaxEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Traits\StoreImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use StoreImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->withWhereHas("categories", function ($query) {
                $query->select('categories.id', 'parent_id', 'name')->where('status', 1);
                $query->with('ancestors', function ($query) {
                    $query->where('status', 1)->orderBy('id', 'asc');
                });
            })
            ->withWhereHas("user", fn ($query) => $query->select('id', 'name'))
            ->notIsAdmin(Auth::user())
            ->orderBy("id", "desc")
            ->get();

        return view("admin.products.index", ['items' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();
        $tax = TaxEnum::cases();
        $categories = Category::withRecursiveQueryConstraint(function (Builder $query) {
            $query->where('categories.status', 1);
        }, function () {

            return Category::treeOf(function ($query) {
                $query->whereNull('parent_id')->where('status', 1);
            })->get()->toTree();
        });
        $brands = Brand::where('status', 1)->get();
        return view("admin.products.create-update", ['categories' => $categories, 'status' => $status, 'langs' => $langs, 'tax' => $tax, 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            if (empty($product->slug)) $product->slug = Str::slug($request->name);
            $product->user_id = Auth::id();
            $product->brand_id = $request->brand_id;
            $product->content = $request->content;
            $product->seo_keywords = $request->seo_keywords;
            $product->seo_description = $request->seo_description;
            $product->status = $request->status;
            $product->price = getMoneyTypeChange($request->price);
            $product->tax = $request->tax;


            if (!is_null($request->image) && is_array($request->image)) $product->images = $this->verifyAndStoreImage($request, "image", "products");


            $product->save();
            $product->categories()->attach($request->category_id);
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.product.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                // dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.',
                    'redirect' => ''
                ];
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $selected_categories = $product->categories->pluck('id')->toArray();

        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();
        $tax = TaxEnum::cases();
        $categories = Category::withRecursiveQueryConstraint(function (Builder $query) {
            $query->where('categories.status', 1);
        }, function () {

            return Category::treeOf(function ($query) {
                $query->whereNull('parent_id')->where('status', 1);
            })->get()->toTree();
        });
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.create-update', ['item' => $product, 'categories' => $categories, 'langs' => $langs, 'status' => $status, 'tax' => $tax, 'selected_categories' => $selected_categories, 'brands' => $brands]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        try {
            //$data = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            if (empty($product->slug)) $product->slug = Str::slug($request->name);
            $product->user_id = Auth::id();
            $product->brand_id = $request->brand_id;
            $product->content = $request->content;
            $product->seo_keywords = $request->seo_keywords;
            $product->seo_description = $request->seo_description;
            $product->status = $request->status;
            $product->price = getMoneyTypeChange($request->price);
            $product->tax = $request->tax;

            if (!is_null($request->image) && is_array($request->image)) $product->images = $this->verifyAndStoreImage($request, "image", "products");

            // $product->update($data, ['id' => $product->id]);
            $product->save();
            $product->categories()->sync($request->category_id);
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.product.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.',
                    'redirect' => ''
                ];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        try {
            $images = json_decode($product->images);

            if (!empty($images)) {
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        File::delete(public_path($image));
                        // Storage::delete("storage/image/products/7QOapzOMR7yRpTLZUYkXvIez00p8JEH3y3WK05Rs.png");
                    }
                }
            }

            $product->delete();
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.product.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                // dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }
        }
    }

    public function statusChange(Request $request, Product $product)
    {
        $this->authorize('statusChange', $product);
        try {
            $validated = $request->validate([
                'data' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $status  = ($request->data === "true") ? 1 : 0;
                $product->update(['status' => $status], ['id' => $product->id]);
            }
        } catch (\Throwable $th) {
        }
    }

    public function popularChange(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'data' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $popular  = ($request->data === "true") ? 1 : 0;
                $product->update(['popular' => $popular], ['id' => $product->id]);
            }
        } catch (\Throwable $th) {
        }
    }
}
