<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'sku',
        'price',
        'stock',
        'unit',
        'status',
        'image_path'
    ];

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}