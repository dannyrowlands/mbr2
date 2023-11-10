<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'hotel_id',
        'type_id',
    ];

    /**
     * Get the hotel for this room.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the type for this room.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
