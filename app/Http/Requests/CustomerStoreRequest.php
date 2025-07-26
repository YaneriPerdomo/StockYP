<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'customer_name' => ['required', 'regex:/^[a-zA-Z]+$/', 'max:55'],
            'customer_lastname' => ['required', 'regex:/^[a-zA-Z0-9]+$/', 'max:55'],
            'card' => ['required', 'unique:customers', 'regex:/^[A-Z-a-z-0-9]|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}+$/'],
            'phone' => ['required', 'regex:/^\+[0-9]{2} [0-9]{3}-[0-9]{7}+$/', 'unique:customers'],
            'address' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'gender_id.required' => 'La :attribute es obligatorio',

            'identity_card_id.required' => 'La :attribute es obligatorio',
            'customer_name.required' => 'El :attribute es obligatorio',
            'customer_name.max' => 'El :attribute no debe exceder los :max caracteres',
            'customer_name.regex' => 'El :attribute no debe numeros o contener caracteres especiales',

            'customer_lastname.required' => 'El :attribute es obligatorio',
            'customer_lastname.max' => 'El :attribute no debe exceder los :max caracteres',
            'customer_lastname.regex' => 'El :attribute no debe numeros o contener caracteres especiales',

            'phone.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',

            'card.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',
            'card.regex' => 'El Número de identificación  o Correo electrónico ingresado no cumple con el formato requerido',
            'card.required' => 'El :attribute es obligatorio',
            'phone.required' => 'El :attribute es obligatorio',

            'phone.regex' => 'El :attribute no tiene un formato válido. Utiliza el siguiente formato: +XX XXX-XXXXXXX, por ejemplo: +58 384-1234567',
            'address.required' => 'La :attribute es obligatorio',
            'address.max' => 'La :attribute no debe exceder los :max caracteres',

        ];
    }
    public function attributes()
    {
        return [
            'customer_name' => 'nombre',
            'customer_lastname' => 'apellido',

            'gender_id' => 'sección de género',
            'identity_card_id' => 'sección tipo de identidad',
            'phone' => 'número de teléfono',
            'card' => 'número de identificación',
            'address' => 'dirección'
        ];
    }
}
