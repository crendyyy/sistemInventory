<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $fillable = [
        'transaction_date', 'description', 'type', 'amount',
        'balance', 'reference', 'transactionable_type',
        'transactionable_id', 'notes', 'user_id',
        'status', 'cancelled_at', 'cancelled_by', 'cancel_reason'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount'           => 'decimal:2',
        'balance'          => 'decimal:2',
        'cancelled_at'     => 'datetime',
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cancelledByUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'cancelled_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
