<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hotel_id = Hotel::all()->random()->id;
        return [
            'number' => fake()->address(),
            'hotel_id' => $hotel_id,
            'room_type_id' => RoomType::where('hotel_id', '=', $hotel_id)->get()->random()->id,
            'created_at' => now(),
        ];
    }
}
