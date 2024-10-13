<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'photo' => 'category_icons/electr.png', // Assuming the file exists in public/category_icons
            ],
            [
                'name' => 'Furniture',
                'photo' => 'category_icons/fur.png',
            ],
            [
                'name' => 'Books',
                'photo' => 'category_icons/books.jpeg',
            ],
            [
                'name' => 'Sports',
                'photo' => 'category_icons/sports.jpeg',
            ],
            [
                'name' => 'Clothing',
                'photo' => 'category_icons/clothing.jpeg',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
