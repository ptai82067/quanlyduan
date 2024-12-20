<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    // Tên bảng tương ứng trong database
    protected $table = 'Khoa';
    protected $primaryKey = 'MaKhoa';
    // Các trường có thể gán mass assignment
    protected $fillable = [
        'TenKhoa',
    ];

    // Tắt timestamps vì bảng này không sử dụng các cột created_at và updated_at
    public $timestamps = false;

    // Quy tắc xác thực (nếu cần thiết)
    public static function getValidationRules()
    {
        return [
            'TenKhoa' => 'required|string|max:191', // Tên khoa không thể trống và không quá 191 ký tự
        ];
    }
}

