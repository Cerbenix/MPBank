<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatableTrait;


    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function generateQR()
    {
        $google2FA = app('pragmarx.google2fa');

        return $google2FA->getQRCodeInline(
            'MPBank',
            $this->email,
            $this->two_factor_secret
        );
    }
}
