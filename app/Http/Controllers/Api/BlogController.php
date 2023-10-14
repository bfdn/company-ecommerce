<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBlogRequest;
use App\Http\Requests\Api\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Article;
use App\Services\Interfaces\BlogInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * @var BlogInterface
     */
    private BlogInterface $blog;

    /**
     * Create a new interface instance.
     * BlogController constructor.
     *
     * @param BlogInterface $blog
     */
    public function __construct(BlogInterface $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // return apiResponse(__('Todo'), 200, $todos);
        return BlogResource::collection($this->blog->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'blog_category_id' => ["required"],
            // 'name.tr' => ['required', "max:255"],
            'name' => ['required', "max:255"],
            'slug' => ['max:255', "unique_translation:articles,slug"],
            // 'slug.*' => ['max:255', "unique_translation:categories,slug"],
            'status' => ['required'],
            "content" => ['max:255'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
        ], [], ['name' => 'Başlık']);
        if ($validator->fails()) {
            return apiResponse(__('Validation error'), 401, ['errors' => $validator->errors()]);
        }


        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|min:6'
        // ]);

        // dd($request->user("api"));

        $item = new Article();
        $item->user_id = $request->user("api")->id;
        $item->fill($request->all());

        $this->blog->store($item);

        return apiResponse(__('Kayıt Eklendi'), 200, $item);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new BlogResource($this->blog->byId($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, string $id)
    {
        /*
        $validator = Validator::make($request->all(), [
            'blog_category_id' => ["required"],
            // 'name.tr' => ['required', "max:255"],
            'name' => ['required', "max:255"],
            'slug.*' => ['max:255', "unique_translation:articles,slug,{$id}"],
            "content" => ['max:255'],
            'status' => ['required'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
        ], [], ['name' => 'Başlık']);
        if ($validator->fails()) {
            return apiResponse(__('Validation error'), 401, ['errors' => $validator->errors()]);
        }
        */

        try {
            $this->blog->update($request->all(), $id);
        } catch (\Throwable $th) {
            return apiResponse(__('Hata'), 200, ["errors" => "Böyle bir kayıt bulunamadı"]);
        }

        return apiResponse(__('Kayıt Güncellendi'), 200, []);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->blog->delete($id);
        return apiResponse(__('Kayıt Silindi'), 200, []);
    }
}
