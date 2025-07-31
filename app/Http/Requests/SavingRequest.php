<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingRequest extends FormRequest
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
            'saving_amount_usd' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'saving_amount_usd.required' => 'El :attribute es obligatorio',
            'saving_amount_usd.integer' => 'El :attribute solo debe contener números',
        ];
    }

    public function attributes()
    {
        return [
            'saving_amount_usd' => 'tasa de interés del crédito ',
        ];
    }
}
