<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'device_type_id' => null,
            'device_brand_id' => null,
            'device_model_id' => null,
            'condition' => $this->faker->randomElement(['working', 'minor_damage', 'major_damage', 'non_functional']),
            'description' => $this->faker->paragraph(3),
            'estimated_weight' => $this->faker->numberBetween(1, 5),
            'intended_action' => $this->faker->randomElement(['sell', 'donate', 'recycle']),
            'suggested_price' => $this->faker->numberBetween(100, 2000),
            'status' => $this->faker->randomElement(['pending', 'available', 'matched', 'in_transit', 'delivered', 'processed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
