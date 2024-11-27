<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucBaiViet extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'danhmucbaiviet';
    protected $primaryKey = 'MaDanhMuc';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TenDanhMuc',
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'TenDanhMuc' => 'required|string|max:191', // Bắt buộc, tối đa 191 ký tự
        ];
    }

    /**
     * Quan hệ với các bài viết thuộc danh mục
     */
    public function baiViet()
    {
        return $this->hasMany(BaiViet::class, 'MaDanhMuc', 'MaDanhMuc');
    }
}
