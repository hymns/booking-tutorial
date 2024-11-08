<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'type_id',
        'name',
        'description'
    ];
    
    /**
     * Get the item type for the item
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the bookings for the item
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
