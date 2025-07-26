<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
{
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
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La :attribute es obligatorio',
            'password.min' => 'La :attribute debe tener al menos :min caracteres',
            'password.confirmed' => 'La confirmación de la contraseña no coincide con la contraseña',
            'password_confirmation.required' => 'La :attribute es obligatorio',
        ];
    }
    public function attributes()
    {
        return [
            'password' => 'Contraseña',
            'password_confirmation' => 'Confirmar contraseña',
        ];
    }
}
