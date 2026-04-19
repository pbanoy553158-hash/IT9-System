<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'supplier_id');
    }

    public function orders(): HasMany
    {
        // Explicitly naming 'supplier_id' fixes the SQL Column Not Found error
        return $this->hasMany(Order::class, 'supplier_id');
    }
}