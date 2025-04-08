<?php

namespace Database\Seeders;

use App\Models\Category;
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

        Product::factory(20)->create()->each(function ($product) use ($categories) {
            $assignedCategories = $categories->random(rand(1, 4))->pluck('id')->toArray();
            $product->categories()->sync($assignedCategories);
        });
    }
}
