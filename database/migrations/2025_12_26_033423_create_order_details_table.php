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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            
            // Liên kết User (Người đặt)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Liên kết Suất chiếu (Có thể để null nếu suất chiếu bị xóa sau này mà vẫn muốn giữ lịch sử đơn)
            $table->foreignId('showtime_id')->nullable()->constrained('showtimes')->onDelete('set null');

            // --- SNAPSHOT DATA (Lưu cứng thông tin tại thời điểm đặt) ---
            // Tại sao? Để nếu sau này Admin đổi tên phim, đổi giá, đổi tên rạp...
            // thì lịch sử mua vé của khách không bị sai lệch.
            
            $table->string('movie_title');
            $table->integer('movie_id'); // Lưu ID phim dạng số nguyên (không foreign key cứng)
            
            $table->string('theater_name');
            $table->string('show_time'); // Giờ chiếu
            $table->date('show_date');   // Ngày chiếu
            
            $table->text('seat_list');   // Lưu danh sách ghế dạng chuỗi: "A1, A2, B5"
            $table->bigInteger('total_price'); // Tổng tiền (VND)
            
            // Thông tin người nhận vé (Snapshot)
            $table->string('user_name');
            $table->string('user_email');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
