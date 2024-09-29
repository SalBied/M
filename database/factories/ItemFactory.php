<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{

    public function definition(): array
    {

        return [
            'seller_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'condition' => $this->faker->randomElement(['new', 'used']),
            'photos' => json_encode([$this->faker->imageUrl(640, 480, 'technics'), $this->faker->imageUrl(640, 480, 'technics')]),
            'category_id' =>random_int(1,10),
            'location' => $this->faker->city,
            'status' => 'active',
        ];
    }
}
