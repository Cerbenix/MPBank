<?php

namespace App\Rules;

use App\Models\Investment;
use Illuminate\Contracts\Validation\Rule;

class AmountAvailable implements Rule
{
    private Investment $investment;

    public function __construct(Investment $investment)
    {
        $this->investment = $investment;
    }

    public function passes($attribute, $value)
    {
        return $this->investment->crypto_amount >= $value;
    }

    public function message()
    {
        return 'Amount available is not enough';
    }
}
