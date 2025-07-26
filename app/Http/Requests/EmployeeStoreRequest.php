<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this required.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the required.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_name' => ['required', 'regex:/^[a-zA-Z]+$/', 'max:60'],
            'employee_lastname' => ['required', 'regex:/^[a-zA-Z]+$/', 'max:60'],
            'card' => ['required', 'unique:employees', 'regex:/^[A-Z-a-z-0-9]|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}+$/'],
            'telephone_number' => ['required', 'regex:/^\+[0-9]{2} [0-9]{3}-[0-9]{7}+$/', 'unique:employees'],
            'address' => ['max:120'],
            'gender_id' => ['required'],
            'identity_card_id' => ['required'],
            'role_id' => ['required'],
            'user' => [ 'unique:users' ,'required', 'regex:/^[A-Z]{1}[a-z]{2,5}[0-9]{2,4}+$/'],
            'employee_email' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}+$/'],
            'password' => ['required', 'regex:/^[A-Z]{1}[a-z]{2,5}[0-9]{2,4}+$/', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'telephone_number.required' => 'El :attribute es obligatorio',
            'employee_name.required' => 'El :attribute es obligatorio',

            'employee_name.max' => 'El :attribute no debe exceder los :max caracteres',
            'telephone_number.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',
            'card.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',

            'employee_name.regex' => 'El :attribute no debe contener caracteres especiales',

            'role_id.required' => 'La :attribute es obligatorio',
            'gender_id.required' => 'La :attribute es obligatorio',

            'identity_card_id.required' => 'La :attribute es obligatorio',

            'employee_lastname.required' => 'El :attribute es obligatorio',
            'employee_lastname.max' => 'El :attribute no debe exceder los :max caracteres',
            'employee_lastname.regex' => 'El :attribute no debe contener caracteres especiales',

            'user.unique' => 'El :attribute ya está en uso. Por favor, elige uno diferente',
            'user.required' => 'El :attribute es obligatorio',
            'user.regex' => 'El :attribute no cumple con los requisitos. Para ser válido, debe comenzar con una letra mayúscula, seguida de entre dos y cinco letras minúsculas, y finalizar con entre dos y cuatro dígitos numéricos. Por favor, revise su entrada y vuelva a intentarlo.',

            'card.regex' => 'El Número de identificación  o Correo electrónico ingresado no cumple con el formato requerido',
            'card.required' => 'El :attribute es obligatorio',

            'telephone_number.regex' => 'El :attribute no tiene un formato válido. Utiliza el siguiente formato: +XX XXX-XXXXXXX, por ejemplo: +58 384-1234567',

            'address.max' => 'La :attribute no debe exceder los :max caracteres',

            'employee_email.required' => 'El :attribute es obligatorio',
            'employee_email.regex' => 'El :attribute no cumple con el formato habitual que tiene',

            'password.required' => 'La :attribute es obligatorio',
            'password.regex' => 'La :attribute no cumple con los requisitos. Para ser válido, debe comenzar con una letra mayúscula, seguida de entre dos y cinco letras minúsculas, y finalizar con entre dos y cuatro dígitos numéricos.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide con la contraseña',
            'password_confirmation.required' => 'El campo de :attribute es obligatorio',
        ];
    }
    public function attributes()
    {
        return [
            'gender_id' => 'sección de género',
            'identity_card_id' => 'sección tipo de identidad',
            'role_id' => 'sección rol de acceso ',
            'employee_name' => 'nombre',
            'employee_lastname' => 'apellido',
            'user' => 'nombre de usuario',
            'employee_email' => 'correo electronico',
            'telephone_number' => 'número de teléfono',
            'card' => 'número de identificación',
            'address' => 'dirección',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmar contraseña',
        ];
    }
}
