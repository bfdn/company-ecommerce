<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'name.tr' => ['required', "max:255"],
            'slug.*' => ['max:255', "unique_translation:articles,slug,{$this->article->id}"],
            "content" => ['max:255'],
            'status' => ['required'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
        ];
    }
}
