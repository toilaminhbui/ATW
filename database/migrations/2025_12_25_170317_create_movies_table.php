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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tên phim
            $table->string('trailer_url'); // Link trailer (Youtube)
            
            // Quản lý ảnh
            $table->string('image_url'); // Đường dẫn hiển thị
            $table->string('file_name')->nullable(); // Tên file để xóa trong storage
            
            $table->text('description'); // Mô tả nội dung
            $table->date('release_date'); // Ngày khởi chiếu
            $table->integer('rating'); // Thời lượng hoặc điểm đánh giá
            
            // Các trạng thái (Boolean)
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_showing')->default(false);
            $table->boolean('is_upcoming')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
