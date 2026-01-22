<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $sizes = [
            ['name' => 'Small', 'short_name' => 'S'],
            ['name' => 'Medium', 'short_name' => 'M'],
            ['name' => 'Large', 'short_name' => 'L'],
            ['name' => 'Extra Large', 'short_name' => 'XL'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
