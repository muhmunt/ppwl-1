<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Using integer ID - change to string if needed via migration
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'tanggal',
        'total',
        'bukti_pembayaran',
        'status_pembayaran',
        'alamat',
        'telepon',
        'metode',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order products for the order
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Get the products for the order through order products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('jumlah', 'harga_satuan')
            ->withTimestamps();
    }
}
