<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transfer;
use App\Services\CurrencyApiService;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    private CurrencyApiService $apiService;

    public function __construct(CurrencyApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function create()
    {
        $accounts = auth()->user()->accounts()->get();
        return view ('account.transfer', ['accounts' => $accounts]);
    }


    public function store(TransferRequest $request)
    {
        $senderAccount = Account::findOrFail($request->sender_account_id);
        $receiverAccount = Account::where('name', $request->receiver_account)->first();
        $senderCurrency = $senderAccount->currency;
        $receiverCurrency = $receiverAccount->currency;

        $receiverAmount = $request->amount;
        if ($senderCurrency !== $receiverCurrency) {
            $conversionRate = $this->apiService->getConversionRate($senderCurrency, $receiverCurrency);
            $receiverAmount = $request->amount * $conversionRate;
        }

        $senderAccount->amount -= $request->amount;
        $receiverAccount->amount += $receiverAmount;

        $senderAccount->save();
        $receiverAccount->save();

        Transfer::create([
            'sender_account_id' => $senderAccount->id,
            'receiver_account_id' => $receiverAccount->id,
            'sender_amount' => $request->amount,
            'receiver_amount' => $receiverAmount,
            'description' => $request->description,
            'transfer_time' => now(),
        ]);

        return redirect()->route('accounts');
    }

}
