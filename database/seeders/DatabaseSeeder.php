<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Phones', 'slug' => 'phones'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Monitors', 'slug' => 'monitors'],
            ['name' => 'Audio', 'slug' => 'audio'],
        ];

        $brands = [
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Dell', 'slug' => 'dell'],
            ['name' => 'HP', 'slug' => 'hp'],
            ['name' => 'Sony', 'slug' => 'sony'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }

        $categoryMap = Category::pluck('id', 'slug');
        $brandMap = Brand::pluck('id', 'slug');

        $products = [
            [
                'name' => 'Dell XPS 13 Developer Laptop',
                'sku' => 'SKU-00001',
                'category' => 'laptops',
                'brand' => 'dell',
                'description' => 'A premium ultrabook with fast performance, long battery life, and a sharp display built for developers and business users.',
                'price' => 1450.00,
                'stock' => 22,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'HP EliteBook Business Pro',
                'sku' => 'SKU-00002',
                'category' => 'laptops',
                'brand' => 'hp',
                'description' => 'A durable business laptop with strong security features, dependable battery life, and a clean professional design.',
                'price' => 1320.00,
                'stock' => 16,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Apple MacBook Air M-Series',
                'sku' => 'SKU-00003',
                'category' => 'laptops',
                'brand' => 'apple',
                'description' => 'A lightweight laptop with excellent performance, silent operation, and a bright display for everyday work and creative tasks.',
                'price' => 1699.00,
                'stock' => 12,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Samsung Galaxy Pro Phone',
                'sku' => 'SKU-00004',
                'category' => 'phones',
                'brand' => 'samsung',
                'description' => 'A flagship smartphone with a vivid screen, strong camera system, and fast processing for productivity and entertainment.',
                'price' => 899.00,
                'stock' => 31,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone Business Edition',
                'sku' => 'SKU-00005',
                'category' => 'phones',
                'brand' => 'apple',
                'description' => 'A reliable premium phone with a smooth user experience, strong security, and a professional camera setup.',
                'price' => 1199.00,
                'stock' => 28,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Sony Studio Headphones',
                'sku' => 'SKU-00006',
                'category' => 'audio',
                'brand' => 'sony',
                'description' => 'Comfortable over-ear headphones with rich sound, noise isolation, and long listening sessions in mind.',
                'price' => 249.00,
                'stock' => 45,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Dell 27 Inch 4K Monitor',
                'sku' => 'SKU-00007',
                'category' => 'monitors',
                'brand' => 'dell',
                'description' => 'A professional 4K monitor designed for sharp visuals, excellent workspace clarity, and modern office setups.',
                'price' => 560.00,
                'stock' => 18,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'HP UltraWide Office Monitor',
                'sku' => 'SKU-00008',
                'category' => 'monitors',
                'brand' => 'hp',
                'description' => 'A wide business monitor that improves multitasking with strong color quality and a clean minimal frame.',
                'price' => 620.00,
                'stock' => 14,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Samsung Wireless Earbuds Pro',
                'sku' => 'SKU-00009',
                'category' => 'audio',
                'brand' => 'samsung',
                'description' => 'Compact wireless earbuds with clear audio, stable connection, and everyday comfort for calls and music.',
                'price' => 189.00,
                'stock' => 52,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Apple Magic Keyboard',
                'sku' => 'SKU-00010',
                'category' => 'accessories',
                'brand' => 'apple',
                'description' => 'A sleek wireless keyboard with responsive keys, minimal design, and excellent typing comfort.',
                'price' => 149.00,
                'stock' => 38,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Dell Precision Wireless Mouse',
                'sku' => 'SKU-00011',
                'category' => 'accessories',
                'brand' => 'dell',
                'description' => 'A smooth and accurate wireless mouse built for daily productivity with long battery life.',
                'price' => 59.00,
                'stock' => 70,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Sony Portable Bluetooth Speaker',
                'sku' => 'SKU-00012',
                'category' => 'audio',
                'brand' => 'sony',
                'description' => 'A compact Bluetooth speaker with balanced sound, modern styling, and dependable battery performance.',
                'price' => 129.00,
                'stock' => 40,
                'is_featured' => false,
                'status' => 'active',
            ],
        ];

        foreach ($products as $item) {
            $brandName = collect($brands)->firstWhere('slug', $item['brand'])['name'];
            $categoryName = collect($categories)->firstWhere('slug', $item['category'])['name'];

            Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'category_id' => $categoryMap[$item['category']],
                    'category_name' => $categoryName,
                    'brand_id' => $brandMap[$item['brand']],
                    'brand_name' => $brandName,
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'is_featured' => $item['is_featured'],
                    'status' => $item['status'],
                    'image_url' => null,
                ]
            );
        }
    }
}