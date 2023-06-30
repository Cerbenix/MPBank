<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\DebitAccountController;
use App\Http\Controllers\Account\InvestmentAccountController;
use App\Http\Controllers\Account\TransferController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Investment\InvestmentController;
use App\Http\Controllers\Investment\InvestmentPurchaseController;
use App\Http\Controllers\Investment\InvestmentSaleController;
use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'create'])->name('register.form');
    Route::post('register', [UserController::class, 'store'])->name('register');

    Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
});



Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('profile', [UserController::class, 'show'])->name('profile');

    Route::get('accounts', [AccountController::class, 'index'])->name('accounts');

    Route::delete('accounts', [AccountController::class, 'delete'])->name('accounts.delete');

    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');

    Route::get('accounts/debit/{id}', [DebitAccountController::class, 'index'])
        ->name('accounts.debit')
        ->where('id', '[0-9]+');

    Route::get('accounts/debit/transfer', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('accounts/debit/transfer', [TransferController::class, 'store'])->name('transfer.store');

    Route::get('accounts/investments/{id}', [InvestmentAccountController::class, 'index'])
        ->name('accounts.investments')
        ->where('id', '[0-9]+');

    Route::get('investments', [InvestmentController::class, 'index'])->name('investments');
    Route::post('investments', [InvestmentController::class, 'search'])->name('investments.search');

    Route::get('investments/purchase/{id}', [InvestmentPurchaseController::class, 'create'])
        ->name('purchase')
        ->where('id', '[0-9]+');
    Route::post('investment/purchase', [InvestmentPurchaseController::class, 'store'])->name('purchase.store');

    Route::get('investments/sell/{id}', [InvestmentSaleController::class, 'create'])
        ->name('sell')
        ->where('id', '[0-9]+');
    Route::post('investment/sell', [InvestmentSaleController::class, 'store'])->name('sell.store');
});
