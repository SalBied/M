<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => User::factory(), // Associate with a user (seller)
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'condition' => $this->faker->randomElement(['new', 'used']),
            'photos' => json_encode([$this->faker->imageUrl(640, 480, 'technics'), $this->faker->imageUrl(640, 480, 'technics')]),
            'category_id' => Category::factory(), // Associate with a category
            'location' => $this->faker->city,
            'status' => 'active', // Default status
        ];
    }
}
