<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:90', 'regex:/^[a-zA-Z0-9-\s]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El :attribute es obligatorio',
            'name.regex' => 'El :attribute no debe contener caracteres especiales',
            'name.max' => 'El :attribute no debe exceder los :max caracteres',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'detalles de la ubicacion',
        ];
    }
}
