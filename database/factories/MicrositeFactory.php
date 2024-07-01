<?php

namespace Database\Factories;

use App\Constants\Constants;
use App\Domains\Microsite\Models\Microsite;
use Illuminate\Database\Eloquent\Factories\Factory;

class MicrositeFactory extends Factory
{
    protected $model = Microsite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = CategoryFactory::new()->create();

        return [
            'name' => $this->faker->unique()->company,
            'logo' => $this->faker->imageUrl(640, 480, 'business', true),
            'category_id' => $category->id,
            'currency' => $this->faker->randomElement(Constants::MICROSITE_CURRENCY),
            'payment_expiration' => $this->faker->numberBetween(1, 30),
            'type' => $this->faker->randomElement(Constants::MICROSITE_TYPES),
        ];
    }
}
