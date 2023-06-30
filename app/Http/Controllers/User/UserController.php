<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FAQRCode\Google2FA;

class UserController extends Controller
{

    private Google2FA $google2FA;

    public function __construct(Google2FA $google2FA)
    {
        $this->google2FA = $google2FA;
    }

    public function create()
    {
        return view('user.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'two_factor_secret' => $this->google2FA->generateSecretKey(),
        ]);

        Auth::login($user);

        return redirect()->route('profile')->with('success', 'Registration successful! Welcome to your profile.');
    }


    public function show(): View
    {
        $user = Auth::user();

        $inlineUrl = $user->generateQR();

        return view('user.profile', compact('user'), compact('inlineUrl'));
    }
}
