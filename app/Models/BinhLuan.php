<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'BinhLuan';
    protected $primaryKey = 'MaBinhLuan';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaBaiViet',
        'NoiDung',
        'MaNguoiBinhLuan',
        'NgayBinhLuan',
    ];
    protected $hidden = ['MaNguoiBinhLuan','MaBaiViet'];
    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'MaBaiViet' => 'required|exists:BaiViet,MaBaiViet', // Phải tồn tại trong bảng BaiViet
            'NoiDung' => 'required|string', // Nội dung bình luận
            'MaNguoiBinhLuan' => 'nullable|numeric', // Phải tồn tại trong bảng GiangVien (hoặc SinhVien nếu là sinh viên)
            'NgayBinhLuan' => 'required|date', // Phải là một ngày hợp lệ
        ];
    }

    /**
     * Mối quan hệ với bài viết
     */
    public function baiViet()
    {
        return $this->belongsTo(BaiViet::class, 'MaBaiViet', 'MaBaiViet');
    }

    /**
     * Mối quan hệ với người bình luận
     */
    public function nguoiBinhLuan()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiBinhLuan', 'MaGiangVien');
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['baiViet', 'nguoiBinhLuan']; // Load thông tin bài viết và người bình luận khi truy vấn
    }
}
