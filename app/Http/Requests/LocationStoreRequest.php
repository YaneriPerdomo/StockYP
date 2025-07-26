<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
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
            'name' => ['required', 'max:90', 'unique:locations', 'regex:/^[a-zA-Z0-9]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El :attribute es obligatorio',
            'name.max' => 'El :attribute no debe exceder los :max caracteres',
            'name.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',
            'name.regex' => 'El :attribute no debe contener caracteres especiales', 
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'detalles de la ubicacion',
        ];
    }
}
