<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'unit',
        'buy_price',
        'sell_price',
        'stock',
        'stock_minimum',
        'description'
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'stock' => 'decimal:2',
        'stock_minimum' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Tambah stok saat pembelian
    public function addStock($qty)
    {
        $this->increment('stock', $qty);
    }

    // Kurangi stok saat penjualan
    public function reduceStock($qty)
    {
        $this->decrement('stock', $qty);
    }
}