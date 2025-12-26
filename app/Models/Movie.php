<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * Các trường được phép Mass Assignment
     */
    protected $fillable = [
        'title',
        'trailer_url',
        'image_url',
        'file_name',
        'description',
        'release_date',
        'rating',
        'is_hot',
        'is_showing',
        'is_upcoming',
    ];

    /**
     * Ép kiểu dữ liệu khi lấy ra từ DB
     */
    protected $casts = [
        'release_date' => 'date:Y-m-d', // Format ngày tháng chuẩn
        'is_hot' => 'boolean',          // 1 -> true, 0 -> false
        'is_showing' => 'boolean',
        'is_upcoming' => 'boolean',
        'rating' => 'integer',
    ];

    // --- RELATIONSHIPS (Quan hệ bảng) ---

    /**
     * Một phim có nhiều suất chiếu
     */
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
    
    /**
     * Một phim có nhiều tin tức liên quan (nếu có bảng news)
     */
     public function news()
     {
         return $this->hasMany(News::class);
     }
}