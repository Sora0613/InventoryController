<?php

namespace Database\Factories;

use App\Models\User;
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
            'user_id' => 11,
            'user_name' => "Sora",
            'name' => $this->faker->name(),
            'JAN' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
        ];
    }
}
