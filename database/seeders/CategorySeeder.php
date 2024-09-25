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
            'Electronics',
            'Furniture',
            'Books',
            'Clothing',
            'Home Appliances',
            'Toys',
            'Vehicles',
            'Sports Equipment',
            'Computers',
            'Mobile Phones'
        ];

        foreach ($categories as $category) {

            Category::create(['name' => $category]);
        }
    }
}
