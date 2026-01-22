<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Dresses',
            'T-Shirts',
            'Jeans',
            'Jackets',
            'Bags',
            'Sportwear',
            'Shoes',
            'Jumpers',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'  => $category,
                'image' => 'categories/' . strtolower(str_replace(' ', '_', $category)) . '.jpg',
            ]);
        }
    }
}

// php artisan db:seed --class=CategorySeeder