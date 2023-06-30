<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class SufficientFunds implements Rule
{
    private ?Account $account;

    public function __construct(Account $account = null)
    {
        $this->account = $account;
    }

    public function passes($attribute, $value)
    {
        return $this->account->amount >= $value;
    }

    public function message()
    {
        return 'The account does not have sufficient funds.';
    }
}
