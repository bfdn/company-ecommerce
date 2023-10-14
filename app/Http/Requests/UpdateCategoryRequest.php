<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            // 'name' => ['required', "max:255", "unique:categories,name," . $this->category->id],
            // 'slug' => ['max:255', "unique:categories,slug," . $this->category->id],
            'name.tr' => ['required', "max:255"],
            'slug.*' => ['max:255', "unique_translation:categories,slug,{$this->category->id}"],
            "content" => ['max:255'],
            'status' => ['required'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
            // "image" => ['image', 'mimetypes:image/jpeg,image/jpg,image/png', "max:2048"]
        ];
    }
}
