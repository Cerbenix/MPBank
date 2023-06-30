<?php

namespace App\Http\Requests;

use App\Models\Investment;
use App\Rules\AmountAvailable;
use App\Rules\TwoFactorCodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $investment = Investment::find($this->investment_id);
        return [
            'amount' => ['required', 'numeric', new AmountAvailable($investment)],
            '2fa_code' => ['required', new TwoFactorCodeValidationRule]
        ];
    }
}
