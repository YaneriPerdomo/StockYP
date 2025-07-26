<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessDataRequest extends FormRequest
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
            'business_name' => ['required',  'max:90'],
            'phone' => ['nullable', 'regex:/^\+[0-9]{2} [0-9]{3}-[0-9]{7}+$/'],
            'email' => ['nullable', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'address' => ['required', 'max:120'],
            'rif' => [ 'regex:/^[A-Z-a-z-0-9]|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}+$/']
        ];

    }
    public function messages()
    {
        return [
            'business_name.required' => 'El :attribute es obligatorio',
            'business_name.max' => 'El :attribute no debe exceder los :max caracteres',
            //'phone.required' => 'El :attribute es obligatorio',
            'phone.regex' => 'El :attribute no tiene un formato válido. Utiliza el siguiente formato: +XX XXX-XXXX, por ejemplo: +58 384-83920',
            //'email.required' => 'El :attribute no debe exceder los :max caracteres',
            'email.regex' => 'El :attribute no cumple con el formato',
            'address.required' => 'La :attribute es obligatorio',
            'address.max' => 'La :attribute no debe exceder los :max caracteres',
            //'rif.required' => 'El :attribute es obligatorio',
            'rif.regex' => 'El número de identificación o Correo electrónico ingresado no cumple con el formato requerido'
        ];
    }
    public function attributes()
    {
        return [
            'business_name' => 'nombre comercial del negocio',
            'phone' => 'teléfono',
            'rif' => 'número de identificación',
            'email' => 'correo electrónico',
            'address' => 'dirección'
        ];
    }

}
