<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        // Get a random category from the database
        $category = Category::inRandomOrder()->first();

        // Generate different data based on the category name
        switch ($category->name) {
            case 'Electronics':
                $title = $this->faker->randomElement([
                    'Used Laptop', 'Smartphone', 'Tablet', 'Bluetooth Headphones', '4K Television'
                ]);
                $description = $this->faker->sentence(10) . ' It comes with all accessories and is in excellent condition.';
                $price = $this->faker->randomFloat(2, 100, 1500);
                $photos = json_encode([
                    "https://loremflickr.com/640/480/electronics",  // Category-specific image for electronics
                    "https://loremflickr.com/640/480/electronics"
                ]);
                break;

            case 'Furniture':
                $title = $this->faker->randomElement([
                    'Wooden Dining Table', 'Leather Sofa', 'Office Chair', 'Wardrobe', 'Bookshelf'
                ]);
                $description = 'This is a well-maintained piece of furniture. ' . $this->faker->sentence(8);
                $price = $this->faker->randomFloat(2, 50, 1000);
                $photos = json_encode([
                    "https://loremflickr.com/640/480/furniture",  // Category-specific image for furniture
                    "https://loremflickr.com/640/480/furniture"
                ]);
                break;

            case 'Clothing':
                $title = $this->faker->randomElement([
                    'Men’s Jacket', 'Women’s Summer Dress', 'Kids Sneakers', 'Leather Boots', 'Wool Sweater'
                ]);
                $description = $this->faker->sentence(12) . ' It has been gently used and is still in great condition.';
                $price = $this->faker->randomFloat(2, 10, 200);
                $photos = json_encode([
                    "https://loremflickr.com/640/480/clothing",  // Category-specific image for clothing
                    "https://loremflickr.com/640/480/clothing"
                ]);
                break;

            case 'Books':
                $title = $this->faker->randomElement([
                    'Fiction Novel', 'Science Textbook', 'Cookbook', 'Self-Help Guide', 'Historical Biography'
                ]);
                $description = 'This book is in good condition with minimal wear. ' . $this->faker->sentence(8);
                $price = $this->faker->randomFloat(2, 5, 50);
                $photos = json_encode([
                    "https://loremflickr.com/640/480/books",  // Category-specific image for books
                    "https://loremflickr.com/640/480/books"
                ]);
                break;

            case 'Sports Equipment':
                $title = $this->faker->randomElement([
                    'Mountain Bike', 'Tennis Racket', 'Basketball Hoop', 'Running Shoes', 'Yoga Mat'
                ]);
                $description = $this->faker->sentence(12) . ' Ideal for both beginners and professionals.';
                $price = $this->faker->randomFloat(2, 20, 500);
                $photos = json_encode([
                    "https://loremflickr.com/640/480/sports",  // Category-specific image for sports equipment
                    "https://loremflickr.com/640/480/sports"
                ]);
                break;

            default:
                $title = $this->faker->sentence(3);
                $description = $this->faker->paragraph;
                $price = $this->faker->randomFloat(2, 10, 1000);
                $photos = json_encode([$this->faker->imageUrl(640, 480, 'technics')]);
                break;
        }

        return [
            'seller_id' => User::factory(),
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'condition' => $this->faker->randomElement(['new', 'used']),
            'photos' => $photos,
            'category_id' => $category->id,
            'location' => $this->faker->city,
            'status' => 'active',
        ];
    }
}
