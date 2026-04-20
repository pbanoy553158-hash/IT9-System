<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Food & Beverages',
            'Raw Materials',
            'Electronic Components',
            'Industrial Tools',
            'Safety Equipment',
            'Office Supplies',
            'Logistics & Packaging',
            'Chemicals & Fluids',
            'Construction Supplies'
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}