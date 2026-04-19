<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // add this line right here
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}