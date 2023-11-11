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
                $room_type = fake()->safeColorName;
                if (
                    !RoomType::
                    where('hotel_id', '=' ,$hotel->id)
                    ->where('type', '=', $room_type)
                    ->first()
                )
                {
                    RoomType::factory()->create([
                        'hotel_id' => $hotel->id,
                        'type' => $room_type
                    ]);
                    $i++;
                }

            } while ($i < rand(3, 10));
        }

        Room::factory(200)->create();
    }
}
