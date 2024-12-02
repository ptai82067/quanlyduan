<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BaiVietDanhMuc extends Pivot
{
    // Tên bảng trung gian
    protected $table = 'BaiVietDanhMuc';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaBaiViet',  // Khóa ngoại trỏ tới bảng BaiViet
        'MaDanhMuc',  // Khóa ngoại trỏ tới bảng DanhMucBaiViet
    ];

    // Tắt timestamps nếu không sử dụng `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bài viết
     */
    public function baiViet()
    {
        return $this->belongsTo(BaiViet::class, 'MaBaiViet', 'MaBaiViet');
    }

    /**
     * Quan hệ với danh mục bài viết
     */
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucBaiViet::class, 'MaDanhMuc', 'MaDanhMuc');
    }
    public static function getValidationRules()
    {
        return [
            'MaBaiViet' => 'required|exists:BaiViet,MaBaiViet', // Bắt buộc, phải tồn tại trong bảng BaiViet
            'MaDanhMuc' => 'required|exists:DanhMucBaiViet,MaDanhMuc', // Bắt buộc, phải tồn tại trong bảng DanhMucBaiViet
        ];
    }
}
