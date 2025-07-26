<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchandiseManagementRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'max:120', 'regex:/^[A-Z|a-z]+$/'],
         ];
    }

    public function messages()
    {
        return [
            'description.required' => 'La :attribute es obligatorio',
            'product_id.required' => 'La :attribute es obligatorio',
            'description.regex' => 'La :attribute no debe contener números o caracteres especiales',
        ];
    }
    public function attributes()
    {
        return [
            'description' => 'descripcion',
            'product_id' => 'selección de productos'
        ];
    }
}
