<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'author', 
        'summary', 
        'content', 
        'image_url', 
        'file_name', 
        'category',
        'movie_id' // Đừng quên trường này
    ];

    /**
     * Quan hệ: Bài viết thuộc về 1 phim (Optional)
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}