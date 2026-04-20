<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Linked users under this supplier
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'supplier_id');
    }

    /**
     * All orders belonging to supplier
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'supplier_id');
    }

    /**
     * Only delivered orders (clean reusable relationship)
     */
    public function deliveredOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'supplier_id')
            ->whereRaw('LOWER(TRIM(status)) = ?', ['delivered']);
    }
}