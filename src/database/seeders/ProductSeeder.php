<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Light Tank' => [
                'name' => 'LT-20 Panther',
                'price' => 150000000,
                'description' => 'Light tank dengan kecepatan tinggi.',
                'stock' => 20,
                'image',
                'status' => true,
            ],
            'Medium Tank' => [
                'name' => 'MT-45 Falcon',
                'price' => 250000000,
                'description' => 'Tank menengah serbaguna.',
                'stock' => 15,
                'image',
                'status' => true,
            ],
            'Heavy Tank' => [
                'name' => 'HT-99 Mammoth',
                'price' => 400000000,
                'description' => 'Tank berat dengan armor kuat.',
                'stock' => 25,
                'image',
                'status' => true,
            ],
            'Main Battle Tank' => [
                'name' => 'MBT-X Lion',
                'price' => 500000000,
                'description' => 'Tank utama modern berteknologi tinggi.',
                'stock' => 30,
                'image',
                'status' => true,
            ],
            'Amphibi' => [
                'name' => 'AMP-10 Crocodile',
                'price' => 300000000,
                'description' => 'Tank amfibi untuk operasi laut dan darat.',
                'stock' => 35,
                'image',
                'status' => true,
            ],
        ];

            foreach ($data as $categoryName => $product) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['description' => null] // ← hanya kalau tabel categories butuh ini
            );
        
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image' => null,
                'active' => true,
                'category_id' => $category->id,
            ]);
        }

    }
}
