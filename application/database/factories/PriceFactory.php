<?php

namespace Database\Factories;

use App\Models\Price;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'currency' => Price::CURRENCY_EUR,
            'amount' => $this->faker->numberBetween(100, 1000),
            'product_id' => Product::factory(),
            'variant_id' => Variant::factory(),
        ];
    }
}
