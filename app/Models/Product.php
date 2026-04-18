<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // This line fixes the red lines

class Product extends Model {
    use HasFactory, SoftDeletes; // Now the editor knows what SoftDeletes is

    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'sku',
        'image_path',
        'price',
        'stock',
        'unit',
        'status',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}