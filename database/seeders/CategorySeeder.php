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
    public function run(): void
    {
        Category::factory()->count(10)->create();

        $categories = [
            'Technology',
            'Fashion',
            'Food',
            'Travel',
            'Sports',
        ];

        foreach ($categories as $category) {
            Category::factory()->create(['name' => $category]);
        }
    }
}
