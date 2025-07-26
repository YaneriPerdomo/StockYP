<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IvaRequest extends FormRequest
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
            'iva' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'iva.required' => 'El :attribute es obligatorio',
            'iva.integer' => 'El :attribute solo debe contener números',
        ];
    }

    public function attributes()
    {
        return [
            'iva' => ' Impuesto al Valor Añadido (IVA)',
        ];
    }
}
