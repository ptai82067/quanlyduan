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
        if (!Schema::hasTable('users')) {
    Schema::create('users', function (Blueprint $table) {
        $table->id();  // Tạo cột id tự động tăng và làm khóa chính
        $table->string('name');
        $table->string('email')->unique();  // Email phải là duy nhất
        $table->timestamp('email_verified_at')->nullable();  // Cột này có thể null
        $table->string('password');
        $table->rememberToken();  // Cột lưu token "remember me"
        $table->timestamps();  // Tạo created_at và updated_at
    });
}

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
