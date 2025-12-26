<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = ['name', 'address', 'total_seats', 'type'];

    public function showtimes() {
        return $this->hasMany(Showtime::class);
    }
}
