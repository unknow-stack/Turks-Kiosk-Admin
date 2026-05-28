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
            ['name' => 'Pita Wraps', 'description' => 'Signature pita wraps and doner-style favorites.', 'display_order' => 1],
            ['name' => 'Rice Meals', 'description' => 'Rice meals and bowls for heavier orders.', 'display_order' => 2],
            ['name' => 'Value Meals', 'description' => 'Bundled kiosk meal sets for quick ordering.', 'display_order' => 3],
            ['name' => 'Add-ons', 'description' => 'Sauces, cheese, extra meat, and other extras.', 'display_order' => 4],
            ['name' => 'Drinks', 'description' => 'Beverages for combo meals.', 'display_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + ['slug' => Str::slug($category['name']), 'is_active' => true]
            );
        }
    }
}
