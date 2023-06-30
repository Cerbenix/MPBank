<?php

namespace App\Http\Requests;

use App\Rules\TwoFactorCodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'two_factor_code' => ['required', new TwoFactorCodeValidationRule]
        ];
    }
}
