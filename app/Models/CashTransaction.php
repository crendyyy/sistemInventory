<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $fillable = [
        'transaction_date', 'description', 'type', 'amount',
        'balance', 'reference', 'transactionable_type',
        'transactionable_id', 'notes'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount'           => 'decimal:2',
        'balance'          => 'decimal:2',
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }
}
