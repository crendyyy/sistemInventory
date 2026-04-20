<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'invoice_no',
        'sale_date',
        'subtotal',
        'discount',
        'tax',
        'total',
        'paid_amount',
        'remaining',
        'status',
        'paid_date',
        'notes'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'paid_date' => 'date',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}