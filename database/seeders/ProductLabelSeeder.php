<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductLabel;

class ProductLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            ['name' => 'New', 'color' => 'label-new'],
            ['name' => 'Sale', 'color' => 'label-sale'],
            ['name' => 'Featured', 'color' => 'label-top'],
            ['name' => 'Popular', 'color' => 'label-primary'],
            ['name' => 'Limited', 'color' => 'label-deal'],
            ['name' => 'Out of Stock', 'color' => 'label-out'],
        ];

        foreach ($labels as $labelData) {
            ProductLabel::create($labelData);
        }
    }
}

// php artisan db:seed --class=ProductLabelSeeder