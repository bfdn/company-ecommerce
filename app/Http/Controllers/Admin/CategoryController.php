<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Language;
use App\Traits\StoreImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use StoreImageTrait;

    function __construct()
    {
        $this->middleware('permission:Kategori Listele|Kategori Ekle|Kategori Düzenle|Kategori Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Kategori Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Kategori Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Kategori Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->with(["parentCategory:id,name", "user"])->notIsAdmin(Auth::user())->orderBy("id", "desc")->get();

        // dd($categories);

        return view("admin.categories.index", ['items' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::withRecursiveQueryConstraint(function (Builder $query) {
            $query->where('categories.status', 1);
        }, function () {
            return Category::treeOf(function ($query) {
                $query->whereNull('parent_id')->where('status', 1);
            })->get()->toTree();
        });

        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();
        // $categories = Category::all();
        return view("admin.categories.create-update", ['categories' => $categories, 'status' => $status, 'langs' => $langs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            $data['user_id'] = Auth::user()->id;
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "categories");

            Category::create($data);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.category.index")->getTargetUrl()
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();

        $categories = Category::withRecursiveQueryConstraint(function (Builder $query) {
            $query->where('categories.status', 1);
        }, function () {
            return Category::treeOf(function ($query) {
                $query->whereNull('parent_id')->where('status', 1);
            })->get()->toTree();
        });

        return view('admin.categories.create-update', ['item' => $category, 'categories' => $categories, 'langs' => $langs, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "categories");

            $category->update($data, ['id' => $category->id]);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.category.index")->getTargetUrl()
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
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        try {
            if ($category->childCategories()->count()) {
                return [
                    'status' => 'warning',
                    'title' => 'Uyarı!!!',
                    'message' => 'Önce alt kategorileri silmeniz gerekir.',
                    'redirect' => ''
                ];
            }

            $category->delete();
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.category.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }
        }
    }


    public function statusChange(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $status  = ($request->status === "true") ? 1 : 0;
                $category->update(['status' => $status], ['id' => $category->id]);
            }
        } catch (\Throwable $th) {
        }
    }
}
