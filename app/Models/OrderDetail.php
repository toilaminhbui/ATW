<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'showtime_id', 'theater_name', 'movie_id', 'movie_title',
        'show_time', 'show_date', 'seat_list', 'total_price',
        'user_id', 'user_name', 'user_email'
    ];
}
