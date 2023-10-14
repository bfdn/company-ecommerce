<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class LanguageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Dil Listele|Dil Ekle|Dil Düzenle|Dil Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Dil Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Dil Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Dil Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $langs = Language::query()->with("user")->notIsAdmin(Auth::user())->orderBy("id", "asc")->get();
        return view('admin.language.index', ['items' => $langs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.language.create-update");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $data['status'] = 1;
            Language::create($data);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.language.index")->getTargetUrl()
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
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        $this->authorize('update', $language);
        return view('admin.language.create-update', ['item' => $language]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $this->authorize('update', $language);
        try {
            $data = $request->except(['_token', '_method']);
            $language->update($data, ['id' => $language->id]);

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.language.index")->getTargetUrl()
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
    public function destroy(Language $language)
    {
        $this->authorize('delete', $language);
        try {
            $language->delete();
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.language.index")->getTargetUrl()
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

    public function statusChange(Request $request, Language $language)
    {
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $language->status  = ($request->status === "true") ? 1 : 0;
                $language->save();
            }
        } catch (\Throwable $th) {
        }
    }
}
