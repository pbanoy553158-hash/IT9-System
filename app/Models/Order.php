<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'order_number',
        'total_amount',
        'priority',
        'notes',
        'status',
        'quantity',
    ];

    /**
     * Supplier user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Supplier account
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderItem::class,
            'order_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₱' . number_format($this->total_amount ?? 0, 2);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {

            if (empty($order->order_number)) {
                $order->order_number =
                    'TRNS-' . strtoupper(bin2hex(random_bytes(3)));
            }

            $order->status = $order->status ?? 'Pending';
        });
    }
}