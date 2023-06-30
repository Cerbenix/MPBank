<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellRequest;
use App\Models\Account;
use App\Models\Investment;
use App\Models\Transaction;
use App\Services\CryptoApiService;
use App\Services\CurrencyApiService;
use Illuminate\Http\Request;

class InvestmentSaleController extends Controller
{
    private CryptoApiService $cryptoApiService;
    private CurrencyApiService $currencyApiService;

    public function __construct(CryptoApiService $cryptoApiService, CurrencyApiService $currencyApiService)
    {
        $this->cryptoApiService = $cryptoApiService;
        $this->currencyApiService = $currencyApiService;
    }

    public function create(Request $request)
    {
        $investment = Investment::find($request->id);
        $account = $investment->account;
        $crypto = $this->cryptoApiService->fetchById($investment->crypto_id);

        $conversionRate = $this->currencyApiService->getConversionRate('USD', $account->currency);

        return view('investment.sell', [
            'investment' => $investment,
            'crypto' => $crypto,
            'account' => $account,
            'conversionRate' => $conversionRate
        ]);
    }

    public function store(SellRequest $request)
    {
        $investment = Investment::find($request->investment_id);
        $account = $investment->account;
        $crypto = $this->cryptoApiService->fetchById($investment->crypto_id);

        $cryptoPrice = $crypto->getPrice();
        $conversionRate = $this->currencyApiService->getConversionRate('USD',$account->currency);
        $saleAmount = $request->amount;

        $salePrice = $saleAmount * $cryptoPrice * $conversionRate;

        $account->amount += $salePrice;

        $account->save();

        if ($saleAmount == $investment->crypto_amount) {
            $investment->delete();
        } else {
            $investment->crypto_amount = $investment->crypto_amount - $saleAmount;
            $investment->save();
        }

        Transaction::create([
            'account_id' => $account->id,
            'crypto_id' => $crypto->getId(),
            'crypto_name' => $crypto->getName(),
            'crypto_amount' => $saleAmount,
            'transaction_type' => 'sold',
            'balance_change' => $salePrice,
            'transaction_time' => now()
        ]);

        return redirect()->route('accounts');
    }
}
