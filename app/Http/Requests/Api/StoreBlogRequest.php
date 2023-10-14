<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
        ];
    }
}
