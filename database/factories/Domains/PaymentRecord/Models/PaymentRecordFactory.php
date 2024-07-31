<?php

namespace Database\Factories\Domains\PaymentRecord\Models;

use App\Domains\Microsite\Models\Microsite;
use App\Domains\PaymentRecord\Models\PaymentRecord;
use Illuminate\Database\Eloquent\Factories\Factory;


class PaymentRecordFactory extends Factory
{
    protected $model = PaymentRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'microsite_id' => Microsite::factory(),
            'reference' => $this->faker->unique()->numerify('REF-#####'),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'due_date' => $this->faker->optional()->date(),
        ];
    }
}
