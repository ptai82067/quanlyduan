<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'BaiViet';
    protected $primaryKey = 'MaBaiViet';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TieuDe',
        'NoiDung',
        'NgayTao',
        'MaNguoiTao',
        'TinhTrang',
    ];
    
    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'TieuDe' => 'required|string|max:191', // Bắt buộc, tối đa 191 ký tự
            'NoiDung' => 'required|string', // Bắt buộc
            'NgayTao' => 'required|date', // Bắt buộc, phải là ngày hợp lệ
            'MaNguoiTao' => 'required|exists:GiangVien,MaGiangVien', // Bắt buộc, phải tồn tại trong bảng GiangVien
            'TinhTrang' => 'nullable|string|max:50', // Tùy chọn, tối đa 50 ký tự
        ];
    }

    /**
     * Mối quan hệ với giảng viên tạo bài viết
     */
    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiTao', 'MaGiangVien');
    }

    /**
     * Phương thức kiểm tra trạng thái bài viết
     */
    public function isPublished()
    {
        return $this->TinhTrang === 'Published';
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    protected $hidden = ['MaNguoiTao'];
    public static function relationsToLoad()
    {
        return ['giangVien']; // Load thông tin giảng viên khi truy vấn
    }
}

