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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Tự động tạo trường 'id' là khóa chính
            $table->string('username', 50)->unique(); // Tên đăng nhập
            $table->string('email',191)->unique(); // Email
            $table->string('password'); // Mật khẩu (hashed)
            $table->foreignId('role_id') // Tham chiếu đến bảng roles
                  ->constrained('roles') // Tạo khóa ngoại với bảng roles
                  ->onDelete('cascade'); // Xóa user khi role bị xóa
            $table->timestamps(); // Tự động tạo 'created_at' và 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
