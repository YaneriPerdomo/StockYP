<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user' => 'required|string|max:55',
            'password' => 'required|max:8',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'El :attribute es obligatorio',
            'user.string' => 'El :attribute no debe contener números o caracteres especiales',
            'user.max' => 'El :attribute no debe exceder los :max caracteres',
            'password.required' => 'La :attribute es obligatorio',
            'password.max' => 'La :attribute no debe exceder los :max caracteres',
        ];
    }
    public function attributes()
    {
        return [
            'user' => 'usuario',
            'password' => 'contraseña',
        ];
    }
}
