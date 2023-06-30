<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Rules\SufficientFunds;
use App\Rules\TwoFactorCodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $currencyApiService = app('CurrencyApiService');
        $cryptoApiService = app('CryptoApiService');

        $cryptoAmount = $this->input('crypto_amount');

        $cryptoId = $this->input('crypto_id');
        $account = Account::find($this->input('account_id'));
        $crypto = $cryptoApiService->fetchById($cryptoId);
        $cryptoPrice = $crypto->getPrice();

        $conversionRate = $currencyApiService->getConversionRate('USD', $account->currency);

        $totalPrice = $cryptoAmount * $cryptoPrice * $conversionRate;
        if ($account->amount >= $totalPrice) {
            $this->merge(['total_price' => $totalPrice]);
            return true;
        }

        throw ValidationException::withMessages([
            'total_price' => 'Insufficient funds to make the purchase.',
        ]);

    }

    public function rules()
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'crypto_amount' => 'required|numeric|min:0.01',
            '2fa_code' => ['required', new TwoFactorCodeValidationRule]
        ];
    }
}
