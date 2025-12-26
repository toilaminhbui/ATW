<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieBanner extends Model
{
    protected $fillable = ['image_url', 'file_name'];
}
