<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Account;

class InvestmentTransfer implements Rule
{
    public function passes($attribute, $value)
    {
        $senderAccount = Account::findOrFail(request()->input('sender_account_id'));
        $receiverAccount = Account::where('name', request()->input('receiver_account'))
            ->where('user_id', $senderAccount->user_id)
            ->first();

        if ($senderAccount->type === 'investment' || $receiverAccount->type === 'investment') {
            if ($senderAccount->user_id !== $receiverAccount->user_id) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'Investment accounts can only be transferred within the same user.';
    }
}
