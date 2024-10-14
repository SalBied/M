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
                'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDuRAc6hFQNexfdp_oyeQRzYfrpKdMtaUZiQ&s', // Assuming the file exists in public/category_icons
            ],
            [
                'name' => 'Furniture',
                'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQvkjWAplBMskn6XXRTz69NNRehS89HzLyB6dJiA5-Tud8p9_Ilr-yt4P-p7-qeolZHTQ&usqp=CAU',
            ],
            [
                'name' => 'Books',
                'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfffdoTeh2_O2erW8-pQx6IpKYJSpx-TKvBg&s ',
            ],
            [
                'name' => 'Sports',
                'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQB2HeOF5k31LuPXrPLg9LvsSFPyDwpSKHsLw&s',
            ],
            [
                'name' => 'Clothing',
                'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnObo_YlxFb6EPZUzqwaBKTvGrFs54f084UvMXwt1eHArRikN_ZNJqT73Gn3VpEdHVqjo&usqp=CAU',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
