<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id', // Added this to link to your suppliers
        'order_number',
        'product_name',
        'quantity',
        'total_amount', 
        'priority',     
        'notes',        
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // This is the link the dashboard "withCount" needs
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
                $order->order_number = 'TRNS-' . strtoupper(bin2hex(random_bytes(3)));
            }
            $order->status = $order->status ?? 'Pending';
        });
    }
}