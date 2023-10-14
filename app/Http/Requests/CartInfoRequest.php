<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartInfoRequest extends FormRequest
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
            'name' => ["required", "max:50"],
            'surname' => ['required', "max:50"],
            'address' => ['required', "max:255"],
            'email' => ['required', "max:255", "email"],
            'phone' => ['required', "max:15"],
            "payment_method" => ['required'],
            "notes" => ['max:255'],
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
            'name' => 'Ad',
            'surname' => 'Soyad',
            'email' => 'Email',
            'address' => 'Adres',
            'phone' => 'Telefon',
            'payment' => 'Ödeme Seçeneği',
            'notes' => 'Sipariş Notu'
        ];
    }
}
