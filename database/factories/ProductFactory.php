<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(App\User::class)->make(),
            'product_name' => $this->faker->word,
            'price' => $this->faker->randomNumber(2),
            'status' => $this->faker->boolean(2)
        ];
    }
}
