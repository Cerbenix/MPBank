<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Rules\InvestmentTransfer;
use App\Rules\SufficientFunds;
use App\Rules\TwoFactorCodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $account = Account::find($this->sender_account_id);
        return [
            'sender_account_id' => 'required|exists:accounts,id',
            'receiver_account' => 'required|exists:accounts,name',
            'amount' =>
                [
                    'required',
                    'numeric',
                    'min:0.01',
                    new SufficientFunds($account)
                ],
            '2fa_code' => ['required', new TwoFactorCodeValidationRule],
            'investment_transfer' => [new InvestmentTransfer],
        ];
    }
}
