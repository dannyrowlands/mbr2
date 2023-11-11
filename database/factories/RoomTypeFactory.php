<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['family', 'single', 'double'];

        return [
            'hotel_id' => Hotel::all()->random()->id,
            'cost' => fake()->randomFloat(2, 100, 1500),
            'type' => $types[array_rand($types, 1)],
            'created_at' => now(),
        ];
    }
}
