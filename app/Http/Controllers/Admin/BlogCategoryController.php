<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\Language;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    use StoreImageTrait;

    function __construct()
    {
        $this->middleware('permission:Blog Kategori Listele|Blog Kategori Ekle|Blog Kategori Düzenle|Blog Kategori Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Blog Kategori Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Blog Kategori Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Blog Kategori Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::query()->with(["user"])->notIsAdmin(Auth::user())->orderBy("id", "desc")->get();

        return view("admin.blog-categories.index", ['items' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();
        $categories = BlogCategory::all();
        return view("admin.blog-categories.create-update", ['categories' => $categories, 'status' => $status, 'langs' => $langs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            $data['user_id'] = Auth::user()->id;
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "bcategories");
            // Str::slug($slug . time());

            BlogCategory::create($data);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.blog-category.index")->getTargetUrl()
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
    public function show(BlogCategory $blogCategory)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $this->authorize('update', $blogCategory);

        $langs = Language::query()->where("status", 1)->orderBy("id", "asc")->get();
        $status = StatusEnum::cases();
        $categories = BlogCategory::query()->with(["user"])->orderBy("id", "desc")->get();

        return view('admin.blog-categories.create-update', ['item' => $blogCategory, 'categories' => $categories, 'langs' => $langs, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $this->authorize('update', $blogCategory);
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "bcategories");

            $blogCategory->update($data, ['id' => $blogCategory->id]);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.blog-category.index")->getTargetUrl()
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
    public function destroy(BlogCategory $blogCategory)
    {
        $this->authorize('delete', $blogCategory);
        try {
            $blogCategory->delete();
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.blog-category.index")->getTargetUrl()
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


    public function statusChange(Request $request, BlogCategory $blogCategory)
    {
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $status  = ($request->status === "true") ? 1 : 0;

                $blogCategory->update(['status' => $status], ['id' => $blogCategory->id]);
            }
        } catch (\Throwable $th) {
        }
    }
}
