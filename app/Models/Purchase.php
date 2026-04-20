<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'invoice_no',
        'purchase_date',
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
        'purchase_date' => 'date',
        'paid_date' => 'date',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}