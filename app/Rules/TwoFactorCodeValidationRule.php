<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorCodeValidationRule implements Rule
{

    public function passes($attribute, $value)
    {
        $credentials = request()->only(['email', 'password']);
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$user) {
            $user = Auth::user();
        }

        $google2fa = app('pragmarx.google2fa');

        return $google2fa->verifyKey($user->two_factor_secret, $value);
    }

    public function message(): string
    {
        return 'Invalid Google2FA code.';
    }
}
