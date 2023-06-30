<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\CryptoApiService;
use App\Services\CurrencyApiService;
use Illuminate\Http\Request;

class InvestmentAccountController extends Controller
{
    private CryptoApiService $cryptoApiService;
    private CurrencyApiService $currencyApiService;

    public function __construct(CryptoApiService $cryptoApiService, CurrencyApiService $currencyApiService)
    {
        $this->cryptoApiService = $cryptoApiService;
        $this->currencyApiService = $currencyApiService;
    }

    public function index($id)
    {
        $account = auth()->user()->accounts()->findOrFail($id);
        $transfers = $account->transfers()->get();
        $transactions = $account->transactions()->get();
        $investments = $account->investments()->get();

        $conversionRate = $this->currencyApiService->getConversionRate('USD', $account->currency);
        $cryptoValues = [];
        foreach ($investments as $investment) {
            $crypto = $this->cryptoApiService->fetchById($investment->crypto_id);
            $cryptoValues[$investment->crypto_id] = $investment->crypto_amount * $crypto->getPrice() * $conversionRate;
        }

        return view(
            'account.investment.index',
            [
                'transfers' => $transfers,
                'account' => $account,
                'transactions' => $transactions,
                'investments' => $investments,
                'cryptoValues' => $cryptoValues
            ]);
    }
}
