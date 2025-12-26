<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            
            // Liên kết với suất chiếu (Showtime)
            // Nếu xóa suất chiếu -> Xóa luôn ghế
            $table->foreignId('showtime_id')->constrained('showtimes')->onDelete('cascade');
            
            $table->string('seat_number'); // Ví dụ: A1, B5, C10
            $table->string('seat_type')->default('normal'); // 'normal' hoặc 'vip'
            
            // Trạng thái đặt: Lưu ID hoặc Email người đặt (Nullable = chưa ai đặt)
            // Ở đây mình lưu user_id (hoặc có thể lưu email tùy logic controller bạn chọn)
            $table->string('booked_by')->nullable()->comment('Lưu user_id hoặc email người đặt');
            
            // Lưu người đang chọn ghế tạm thời (để xử lý realtime sau này nếu cần)
            $table->string('selected_by')->nullable(); 

            $table->timestamps();
            
            // Index kép: Giúp tìm kiếm nhanh để check trùng ghế (Quan trọng)
            $table->index(['showtime_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
