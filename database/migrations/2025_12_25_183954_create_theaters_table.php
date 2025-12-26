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
        Schema::create('theaters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên rạp (Ví dụ: Phòng 1, Rạp IMAX)
            $table->string('address')->nullable(); // Vị trí (Tầng 3, Khu B...)
            $table->integer('total_seats')->default(60); // Tổng số ghế (để tham khảo)
            $table->string('type')->default('2D'); // 2D, 3D, IMAX
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theaters');
    }
};
