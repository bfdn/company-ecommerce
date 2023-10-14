<?php

namespace App\Http\Controllers\Admin;

use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Traits\StoreImageTrait;

class SettingsController extends Controller
{
    use StoreImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::first();
        $comments_status = YesNoEnum::cases();

        return view("admin.settings.update", ['item' => $settings, 'comments_status' => $comments_status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, Settings $settings)
    {
        if ($request->ajax()) {
            $settings = Settings::first();
            $settings->phone_1 = $request->phone_1;
            $settings->phone_2 = $request->phone_2;
            $settings->category_products = $request->category_products;
            $settings->category_articles = $request->category_articles;
            $settings->blog_articles = $request->blog_articles;
            $settings->home_products = $request->home_products;
            $settings->home_articles = $request->home_articles;
            $settings->comments_status = $request->comments_status;
            $settings->seo_keywords = $request->seo_keywords;
            $settings->seo_description = $request->seo_description;

            if (!is_null($request->logo)) $settings->logo = $this->verifyAndStoreImage($request, "logo", "settings");
            try {
                $settings->save();

                if (request()->ajax()) {
                    // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                    return [
                        'status' => 'success',
                        'title' => 'İşlem Başarılı',
                        'message' => 'Kayıt Güncellendi',
                        'redirect' => to_route("admin.settings.index")->getTargetUrl()
                    ];
                }

                return back()->with('response', [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Güncellendi'
                ]);
            } catch (\Throwable $th) {
                if (request()->ajax()) {
                    return [
                        'status' => 'error',
                        'title' => 'Hata!!!',
                        'message' => 'Sistemde bir hata oluştu !.',
                        'redirect' => ''
                    ];
                }

                return back()->with('response', [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.'
                ]);
            }
        } else {

            return redirect()->back();
        }
    }

    public function update___(UpdateSettingsRequest $request, Settings $settings)
    {
        $settings = Settings::first();
        $settings->phone_1 = $request->phone_1;
        $settings->phone_2 = $request->phone_2;
        $settings->category_products = $request->category_products;
        $settings->category_articles = $request->category_articles;
        $settings->blog_articles = $request->blog_articles;
        $settings->home_products = $request->home_products;
        $settings->home_articles = $request->home_articles;
        $settings->comments_status = $request->comments_status;
        $settings->seo_keywords = $request->seo_keywords;
        $settings->seo_description = $request->seo_description;

        if (!is_null($request->logo)) $settings->logo = $this->verifyAndStoreImage($request, "logo", "settings");
        try {
            $settings->save();
        } catch (\Exception $e) {
            // return $e->getMessage();
            return back()->with('response', [
                'status' => 'error',
                'type' => 'danger',
                'message' => 'Sistemde bir hata oluştu !.'
            ]);
        }

        // return redirect()->route("settings");
        return back()->with('response', [
            'status' => 'success',
            'type' => 'success',
            'message' => 'İşlem Başarılı!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
