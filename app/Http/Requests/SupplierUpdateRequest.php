<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'gender_id' => ['required'],
            'identity_card_id' => ['required'],
            'name' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/', 'max:90'],
            'card' => ['required', 'regex:/^[A-Z-a-z-0-9]|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}+$/'],
            'telephone_number' => ['nullable', 'regex:/^\+[0-9]{2} [0-9]{3}-[0-9]{7}+$/'],
            'address' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'gender_id.required' => 'La :attribute es obligatorio',

            'identity_card_id.required' => 'La :attribute es obligatorio',
            'name.required' => 'El :attribute es obligatorio',
            'name.max' => 'El :attribute no debe exceder los :max caracteres',
            'name.regex' => 'El :attribute no debe contener caracteres especiales',

            'card.regex' => 'El Número de identificación  o Correo electrónico ingresado no cumple con el formato requerido',
            'card.required' => 'El :attribute es obligatorio',

            'telephone_number.regex' => 'El :attribute no tiene un formato válido. Utiliza el siguiente formato: +XX XXX-XXXXXXX, por ejemplo: +58 384-1234567',
            'address.required' => 'La :attribute es obligatorio',

            'address.max' => 'La :attribute no debe exceder los :max caracteres',

        ];
    }
    public function attributes()
    {
        return [
            'gender_id' => 'sección de género',
            'identity_card_id' => 'sección tipo de identidad',
            'name' => 'nombre del proveedor',
            'telephone_number' => 'número de teléfono',
            'card' => 'número de identificación',
            'address' => 'dirección'
        ];
    }
}
