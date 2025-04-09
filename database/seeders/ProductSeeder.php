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
        $categories = Category::factory(10)->create();
        $ingredients = Ingredient::factory(50)->create();

        Product::factory(20)->create()->each(function ($product) use ($categories, $ingredients) {
            $assignedCategories = $categories->random(rand(1, 4))->pluck('id')->toArray();
            $product->categories()->sync($assignedCategories);

            $assignedIngredients = $ingredients->random(rand(2, 6))->pluck('id')->toArray();
            $product->ingredients()->sync($assignedIngredients);
        });
    }
}
