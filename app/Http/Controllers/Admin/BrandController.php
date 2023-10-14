<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Marka Listele|Marka Ekle|Marka Düzenle|Marka Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Marka Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Marka Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Marka Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()->with("user")->notIsAdmin(Auth::user())->orderBy("id", "asc")->get();
        return view('admin.brands.index', ['items' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.brands.create-update");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            $data['status'] = 1;
            $data['user_id'] = auth()->id();
            // Str::slug($slug . time());

            Brand::create($data);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.brand.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
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
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $this->authorize('update', $brand);
        return view('admin.brands.create-update', ['item' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->authorize('update', $brand);
        try {
            $data = $request->except(['_token', '_method']);
            if (empty($data['slug'])) $data['slug'] = Str::slug($request->name);
            $brand->update($data, ['id' => $brand->id]);


            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.brand.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
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
    public function destroy(Brand $brand)
    {
        $this->authorize('delete', $brand);
        try {
            $brand->delete();
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.brand.index")->getTargetUrl()
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

    public function statusChange(Request $request, Brand $brand)
    {
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $brand->status  = ($request->status === "true") ? 1 : 0;
                $brand->save();
            }
        } catch (\Throwable $th) {
        }
    }
}
