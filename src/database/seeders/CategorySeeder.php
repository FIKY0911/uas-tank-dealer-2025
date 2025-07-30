<?php

namespace Database\Seeders;

// use App\Enums\ProductCategory;

use App\Enums\CategoryProduct;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            CategoryProduct::LIGHTTANK->value,
            CategoryProduct::MEDIUMTANK->value,
            CategoryProduct::HEAVYTANK->value,
            CategoryProduct::MAINBATTLETANK->value,
            CategoryProduct::AMPHIBIOUS->value,
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['is_active' => true]
            );
        }
    }
}
