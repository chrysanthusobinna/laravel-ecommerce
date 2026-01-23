<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productsPerCategory = 6;

        $productNames = [
            'Dresses'   => ['Summer Dress', 'Evening Gown', 'Floral Dress', 'Casual Dress', 'Maxi Dress', 'Party Dress'],
            'T-Shirts'  => ['Basic T-Shirt', 'Graphic Tee', 'Cotton T-Shirt', 'Oversized Tee', 'V-Neck T-Shirt', 'Printed Tee'],
            'Jeans'     => ['Skinny Jeans', 'Straight Jeans', 'High-Waist Jeans', 'Ripped Jeans', 'Slim Fit Jeans', 'Classic Denim'],
            'Jackets'   => ['Leather Jacket', 'Denim Jacket', 'Bomber Jacket', 'Winter Coat', 'Suede Jacket', 'Puffer Jacket'],
            'Bags'      => ['Handbag', 'Shoulder Bag', 'Crossbody Bag', 'Tote Bag', 'Mini Bag', 'Travel Bag'],
            'Sportwear' => ['Sports Bra', 'Gym Leggings', 'Training Top', 'Running Shorts', 'Yoga Pants', 'Fitness Set'],
            'Shoes'     => ['Sneakers', 'Sandals', 'Heels', 'Flats', 'Boots', 'Slip-On Shoes'],
            'Jumpers'   => ['Wool Jumper', 'Knit Jumper', 'Oversized Jumper', 'Crewneck Jumper', 'Cable Knit Jumper', 'Casual Jumper'],
        ];

        Category::whereIn('name', array_keys($productNames))
            ->get()
            ->each(function ($category) use ($productsPerCategory, $productNames) {

                for ($i = 0; $i < $productsPerCategory; $i++) {

                    Product::create([
                        'name'        => $productNames[$category->name][$i],
                        'description' => 'High quality ' . strtolower($productNames[$category->name][$i]) .
                                          ' designed for comfort and everyday use.',
                        'price'       => rand(20, 150),
                        'category_id' => $category->id,
                    ]);
                }
            });
    }
}

// php artisan db:seed --class=ProductSeeder