<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'user_id',
        'item_id',
        'start_date',
        'end_date',
        'status'
    ];

    /**
     * Get the item for the booking
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user for the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
