<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        User::factory()->count(10)->create();

        // Create 5 categories
        $this->call(CategorySeeder::class);

        // Create 20 items
        Item::factory()->count(20)->create();

        // Create 15 favorites
        Favorite::factory()->count(15)->create();
    }
}
