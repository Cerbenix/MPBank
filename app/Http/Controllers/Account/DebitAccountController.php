<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebitAccountController extends Controller
{
    public function index(int $id)
    {
        $account = auth()->user()->accounts()->findOrFail($id);
        $transfers = $account->transfers()->get();
        return view('account.debit.index', ['transfers' => $transfers, 'account' => $account]);
    }


}
