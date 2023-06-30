<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type' => 'required|in:debit,investment',
            'currency' => 'required|string',
            'amount' => 'required|numeric',
        ];
    }
}
