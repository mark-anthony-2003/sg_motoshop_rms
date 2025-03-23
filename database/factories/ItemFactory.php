<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name'     => fake()->word(),
            'item_image'    => fake()->imageUrl(640, 470, 'products'),
            'price'         => fake()->randomFloat(0, 100, 1000),
            'stocks'        => fake()->numberBetween(0, 500),
            'sold'          => fake()->numberBetween(0, 200),
            'item_status'   => fake()->randomElement(['in_stock', 'out_of_stock'])
        ];
    }
}
