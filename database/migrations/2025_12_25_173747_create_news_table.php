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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            
            $table->string('title'); // Tiêu đề bài viết
            $table->string('author'); // Tên người viết (Lấy từ User Name)
            
            $table->text('summary'); // Tóm tắt ngắn (hiển thị ở card danh sách)
            $table->longText('content'); // Nội dung chi tiết (Chứa HTML từ editor)
            
            // Quản lý ảnh bìa
            $table->string('image_url'); 
            $table->string('file_name')->nullable(); // Để tiện xóa file trong storage
            
            $table->string('category')->default('Tin tức'); // Ví dụ: Review, Khuyến mãi...
            
            // Liên kết với bảng Movies (Optional - Có thể null nếu bài viết chung chung)
            // onUpdate('cascade') -> Nếu ID phim đổi thì đây đổi theo
            // onDelete('set null') -> Nếu phim bị xóa, bài viết vẫn còn nhưng movie_id về null
            $table->foreignId('movie_id')
                  ->nullable()
                  ->constrained('movies')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
