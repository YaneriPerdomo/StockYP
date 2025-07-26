<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRateRequest extends FormRequest
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
            'credit_rate' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'credit_rate.required' => 'El :attribute es obligatorio',
            'credit_rate.integer' => 'El :attribute solo debe contener números',
        ];
    }

    public function attributes()
    {
        return [
            'credit_rate' => 'tasa de interés del crédito ',
        ];
    }
}
