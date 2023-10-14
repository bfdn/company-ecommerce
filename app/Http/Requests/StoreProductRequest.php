<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => ["required"],
            'name.tr' => ['required', "max:255"],
            'slug.*' => ['max:255', "unique_translation:products,slug"],
            'status' => ['required'],
            'price' => ['required'],
            'tax' => ['required'],
            "content" => ['max:255'],
            "seo_keywords" => ['max:255'],
            "seo_description" => ['max:255'],
            "image.*" => ["image", "mimes:png,jpeg,jpg", "max:2048"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'slug.*' => 'Slug alanı',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'A title is required',
    //         'body.required' => 'A message is required',
    //     ];
    // }
}
