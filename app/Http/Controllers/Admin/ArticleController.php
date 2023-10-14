<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\BlogCategory;
use App\Models\Language;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class ArticleController extends Controller
{
    use StoreImageTrait;

    function __construct()
    {
        $this->middleware('permission:Yazı Listele|Yazı Ekle|Yazı Düzenle|Yazı Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Yazı Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Yazı Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Yazı Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $articles = Article::query()->with(["category:id,name", "user"])
            ->notIsAdmin(Auth::user())
            ->orderBy("id", "desc")->get();

        return view("admin.articles.index", ['items' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = StatusEnum::cases();
        $categories = BlogCategory::all();
        return view("admin.articles.create-update", ['categories' => $categories, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        // $this->authorize('create', 'App\Models\Article');
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);

            $data['user_id'] = Auth::user()->id;
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "articles");

            Article::create($data);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.article.index")->getTargetUrl()
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
    public function show(Article $article)
    {
        // $this->authorize('view', $article);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $status = StatusEnum::cases();
        $categories = BlogCategory::query()->with(["user"])->orderBy("id", "desc")->get();


        return view('admin.articles.create-update', ['item' => $article, 'categories' => $categories, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            if (!is_null($request->image)) $data["image"] = $this->verifyAndStoreImage($request, "image", "articles");

            $article->update($data, ['id' => $article->id]);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.article.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                //dd($th->getMessage());
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
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        try {
            $article->delete();
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.article.index")->getTargetUrl()
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


    public function statusChange(Request $request, Article $article)
    {
        $this->authorize('statusChange', $article);
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);

            if ($validated) {
                $status  = ($request->status === "true") ? 1 : 0;
                $article->update(['status' => $status], ['id' => $article->id]);
            }
        } catch (\Throwable $th) {
        }
    }
}
