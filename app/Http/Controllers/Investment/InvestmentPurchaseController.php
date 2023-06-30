<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Account;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Services\CryptoApiService;
use App\Services\CurrencyApiService;
use Illuminate\Http\Request;

class InvestmentPurchaseController extends Controller
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
        $accounts = auth()->user()->accounts()->where('type', 'investment')->get();
        $id = $request->id;
        $crypto = $this->cryptoApiService->fetchById($id);
        $conversionRate = [];
        foreach ($accounts as $account) {
            $conversionRate[$account->id] = $this
                ->currencyApiService
                ->getConversionRate('USD', $account->currency);
        }
        return view(
            'investment.purchase',
            [
                'crypto' => $crypto,
                'accounts' => $accounts,
                'conversionRate' => $conversionRate
            ]);
    }

    public function store(PurchaseRequest $request)
    {
        $account = Account::find($request->account_id);

        $crypto = $this->cryptoApiService->fetchById($request->crypto_id);
        $cryptoName = $crypto->getName();

        $account->amount -= $request->total_price;

        $account->save();

        $investment = Investment::where('account_id', $account->id)
            ->where('crypto_id', $request->crypto_id)
            ->first();

        if ($investment) {
            $investment->crypto_amount += $request->crypto_amount;
            $investment->save();
        } else {
            Investment::create([
                'account_id' => $account->id,
                'crypto_id' => $request->crypto_id,
                'crypto_name' => $cryptoName,
                'crypto_amount' => $request->crypto_amount
            ]);
        }


        Transaction::create([
            'account_id' => $account->id,
            'crypto_id' => $request->crypto_id,
            'crypto_name' => $cryptoName,
            'crypto_amount' => $request->crypto_amount,
            'transaction_type' => 'bought',
            'balance_change' => $request->total_price,
            'transaction_time' => now()
        ]);

        return redirect()->route('accounts');
    }
}
