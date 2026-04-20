<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact_person', 'phone', 'email', 'address',
        'credit_limit', 'notes'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
