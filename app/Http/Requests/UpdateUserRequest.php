<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        //$this->request->add(['id' => $this->user->id]);
        return [
            //"id" => "exists:users,id",
            'name' => ["required"],
            'role' => ["required"],
            "email" => ["required", "unique:users,email," . $this->user->id],
            "password" => ["nullable", Password::min(8)->symbols()->mixedCase()->letters()->numbers()],
            "password_re" => ["nullable", "same:password"]
        ];
    }
}
