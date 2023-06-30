<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountCreateRequest;
use App\Models\Account;
use App\Services\CurrencyApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    private CurrencyApiService $apiService;

    public function __construct(CurrencyApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $user = auth()->user();
        $debitAccounts = $user->accounts()->where('type', 'debit')->get();
        $investmentAccounts = $user->accounts()->where('type', 'investment')->get();
        return view(
            'user.accounts',
            [
                'debitAccounts' => $debitAccounts,
                'investmentAccounts' => $investmentAccounts
            ]);
    }

    public function create()
    {
        $currencies = $this->apiService->getCurrencies();
        return view('account.create', ['currencies' =>$currencies]);
    }

    public function store(AccountCreateRequest $request): RedirectResponse
    {
        $account = Account::create([
            'user_id' => auth()->user()->id,
            'type' => $request->type,
            'currency' => $request->currency,
            'amount' => $request->amount,
        ]);

        $accountId = $account->id;

        $accountName = 'PBNK' . str_pad($accountId, 5, '0', STR_PAD_LEFT);

        $account->name = $accountName;
        $account->save();

        return redirect()->route('accounts');
    }

    public function delete(Request $request): RedirectResponse
    {
        $account = Account::find($request->account_id);
        $account->delete();

        return redirect()->route('accounts');
    }
}
