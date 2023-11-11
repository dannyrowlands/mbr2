<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Hotel::factory(10)->create();

        foreach(Hotel::all() as $hotel) {
            $i = 0;
            do {
                RoomType::factory()->create([
                    'hotel_id' => $hotel->id,
                    'type' => fake()->safeColorName
                ]);
                $i++;
            } while ($i < rand(3, 10));
        }

        Room::factory(200)->create();
    }
}
