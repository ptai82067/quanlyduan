<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'bomon';
    protected $primaryKey = 'MaBoMon';
    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TenBoMon', // Tên bộ môn
    ];

    // Tắt timestamps nếu không sử dụng `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bảng GiangVien.
     * Một bộ môn có thể có nhiều giảng viên.
     */
    public function giangVien()
    {
        return $this->hasMany(GiangVien::class, 'MaBoMon', 'MaBoMon');
    }
    public static function getValidationRules()
    {
        return [
            'TenBoMon' => 'required|string|max:191', // Tên bộ môn không được rỗng, dạng chuỗi, tối đa 191 ký tự
        ];
    }
}
