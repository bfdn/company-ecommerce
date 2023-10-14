<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            'name' => ["required", "unique:brands,name," . $this->brand->id],
            'slug' => ["required", "unique:brands,slug," . $this->brand->id],
            // 'slug'=>["required","unique:brands,slug,id"]
        ];
    }
}
