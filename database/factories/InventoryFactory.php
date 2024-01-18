<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inventory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // generate a fake inventory data
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'JAN' => $this->faker->randomNumber(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'user_id' => 1,
        ];
    }
}
