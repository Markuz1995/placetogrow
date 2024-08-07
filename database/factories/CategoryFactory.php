<?php

namespace Database\Factories;

use App\Domains\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        $name = substr($name, 0, 30);

        return [
            'name' => $name,
            'enabled_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
