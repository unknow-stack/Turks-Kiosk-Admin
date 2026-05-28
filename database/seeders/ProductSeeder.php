<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Pita Wraps
            ['Pita Wraps', 'Beef Pita Wrap', 'TK-PITA-BEEF', 'Your all-time, 100% beefy favorite!', 80, true, 1, 'beef-pita-wrap.png'],
            ['Pita Wraps', 'Chicken Pita Wrap', 'TK-PITA-CHICKEN', "Chicken like you've never had before!", 80, true, 2, 'chicken-pita-wrap.png'],
            ['Pita Wraps', 'Kebab Wrap', 'TK-PITA-KEBAB', 'Pure beef strip grilled to perfection!', 85, true, 3, 'kebab-wrap.png'],
            ['Pita Wraps', 'Chicken Kebab Wrap', 'TK-PITA-CHICKEN-KEBAB', 'Chicken kebab wrap with grilled flavor.', 85, true, 4, 'chicken-kebab-wrap.png'],
            ['Pita Wraps', 'Hotdog Wrap', 'TK-PITA-HOTDOG', 'The Hotdog Shawarma flavor.', 85, false, 5, 'hotdog-wrap.png'],
            ['Pita Wraps', 'Small Pita Wrap', 'TK-PITA-SMALL', 'Small pita wrap with beef and chicken.', 60, false, 6, 'small-pita-wrap.png'],

            // Rice Meals
            ['Rice Meals', 'Beef Rice', 'TK-RICE-BEEF', 'Pump up your Beef Rice cravings!', 130, true, 1, 'beef-rice.png'],
            ['Rice Meals', 'Chicken Rice', 'TK-RICE-CHICKEN', 'The best Chicken Rice ever!', 130, true, 2, 'chicken-rice.png'],
            ['Rice Meals', 'Kebab Rice', 'TK-RICE-KEBAB', 'Twice the kebab goodness in one meal!', 150, true, 3, 'kebab-rice.png'],
            ['Rice Meals', 'Chicken Kebab Rice', 'TK-RICE-CHICKEN-KEBAB', 'Chicken kebab rice meal with signature toppings.', 150, false, 4, 'chicken-kebab-rice.png'],
            ['Rice Meals', 'Hotdog Rice', 'TK-RICE-HOTDOG', 'The Hotdog Shawarma flavor with rice.', 150, false, 5, 'hotdog-rice.png'],
            ['Rice Meals', 'Rice Bowl', 'TK-RICE-BOWL', 'Beef and chicken rice bowl. On the go! Possibowl!', 85, true, 6, 'rice-bowl.png'],
            ['Rice Meals', 'Beef Rice Steak', 'TK-RICE-BEEF-STEAK', 'Choice beef cut, infused with signature recipe.', 240, true, 7, 'beef-rice-steak.png'],
            ['Rice Meals', 'Chicken Rice Steak', 'TK-RICE-CHICKEN-STEAK', 'Grilled to juicy perfection.', 180, false, 8, 'chicken-rice-steak.png'],

            // Value Meals / Platters
            ['Value Meals', 'Beef & Chicken Platter', 'TK-PLATTER-BEEF-CHICKEN', 'The best of both worlds!', 210, true, 1, 'beef-chicken-platter.png'],
            ['Value Meals', 'Beef & Kebab Platter', 'TK-PLATTER-BEEF-KEBAB', 'Delightful beef doner and perfectly grilled kebab.', 210, true, 2, 'beef-kebab-platter.png'],
            ['Value Meals', 'Chicken & Kebab Platter', 'TK-PLATTER-CHICKEN-KEBAB', 'Delish chicken doner and perfectly grilled kebab.', 210, false, 3, 'chicken-kebab-platter.png'],

            // Add-ons
            ['Add-ons', 'Turks Java Rice', 'TK-ADD-JAVA-RICE', 'Upgrade your rice experience!', 25, false, 1, 'turks-java-rice.png'],
            ['Add-ons', 'Turks Fries', 'TK-ADD-FRIES', 'Crispy fries add-on for your order.', 45, false, 2, 'turks-fries.png'],
            ['Add-ons', 'Cheddar Cheese', 'TK-ADD-CHEDDAR', 'Cheesier than ever!', 15, false, 3, 'cheddar-cheese.png'],
            ['Add-ons', 'Turks Sauces', 'TK-ADD-SAUCES', 'Signature sauces for extra flavor.', 15, false, 4, 'turks-sauces.png'],

            // Drinks
            ['Drinks', 'Turks Water', 'TK-DRINK-WATER', 'Bottled water.', 20, false, 1, 'turks-water.png'],
            ['Drinks', 'Coke Mismo', 'TK-DRINK-COKE-MISMO', 'For solo meals and value meals only.', 25, false, 2, 'coke-mismo.png'],
        ];

        foreach ($products as [$categoryName, $name, $sku, $description, $price, $featured, $order, $image]) {
            $category = Category::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'price' => $price,
                    'image_url' => asset('assets/images/products/' . $image),
                    'is_available' => true,
                    'is_featured' => $featured,
                    'stock_status' => 'in_stock',
                    'display_order' => $order,
                ]
            );
        }
    }
}
