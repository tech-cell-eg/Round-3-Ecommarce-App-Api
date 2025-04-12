<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryNames = ['hot', 'popular', 'top', 'combo'];
        $categories = collect();

        foreach ($categoryNames as $name) {
            $categories->push(Category::create(['name' => $name]));
        }

        $ingredientNames = [
            'tomato',
            'onion',
            'garlic',
            'lettuce',
            'cucumber',
            'carrot',
            'potato',
            'bell pepper',
            'spinach',
            'cabbage',
            'apple',
            'banana',
            'strawberry',
            'pineapple',
            'mango',
            'orange',
            'chicken',
            'beef',
            'cheese',
            'eggs',
            'milk',
            'butter',
            'flour',
            'sugar',
            'salt',
            'pepper',
            'oregano',
            'basil',
            'parsley',
            'cinnamon',
        ];

        $ingredients = collect();
        foreach ($ingredientNames as $name) {
            $ingredients->push(Ingredient::create(['name' => $name]));
        }

        Product::factory(20)->create()->each(function ($product) use ($categories, $ingredients) {
            $assignedCategories = $categories->random(rand(1, 2))->pluck('id')->toArray();
            $product->categories()->sync($assignedCategories);

            $assignedIngredients = $ingredients->random(rand(3, 6))->pluck('id')->toArray();
            $product->ingredients()->sync($assignedIngredients);
        });
    }
}
