<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'investment_transactions';

    public $timestamps = false;
    protected $fillable = [
        'account_id',
        'crypto_id',
        'crypto_name',
        'crypto_amount',
        'balance_change',
        'transaction_type',
        'transaction_time'
    ];
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

}
