<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id', 'show_date', 'show_time', 
        'theater_id', 'normal_price', 'vip_price'
    ];

    // Quan hệ: Một lịch chiếu thuộc về một phim
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    
    public function theater()
    { 
        return $this->belongsTo(Theater::class); 
    }
}
