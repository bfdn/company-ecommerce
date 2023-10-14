<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Support\Facades\DB;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => ['required', "max:255", "unique_translation:categories,name"],
            // 'name.*' => ["max:255", UniqueTranslationRule::for('categories', 'name')],
            // 'name.tr' => ["unique_translation:categories"],
            // 'name.*' => ["unique_translation:categories,name"],

            'name.tr' => ['required', "max:255"],
            'slug.*' => ['max:255', "unique_translation:categories,slug"],
            'status' => ['required'],
            "content" => ['max:255'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
            // "image" => ['image', 'mimetypes:image/jpeg,image/jpg,image/png', "max:2048"]
        ];
    }
}
