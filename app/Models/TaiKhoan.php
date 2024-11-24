<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'TaiKhoan';
    protected $primaryKey = 'MaTaiKhoan';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TenDangNhap',
        'MatKhau',
        'VaiTro',
        'MaNguoiDung',
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'TenDangNhap' => 'required|string|max:50|unique:TaiKhoan,TenDangNhap', // Bắt buộc, tối đa 50 ký tự, phải duy nhất
            'MatKhau' => 'required|string|min:8|max:191', // Bắt buộc, tối thiểu 8 ký tự
            'VaiTro' => 'nullable|string|max:50', // Không bắt buộc, tối đa 50 ký tự
            'MaNguoiDung' => 'nullable|integer', // Có thể rỗng, nếu có phải là số nguyên
        ];
    }

    /**
     * Mối quan hệ với bảng Người dùng (có thể là SinhVien hoặc GiangVien)
     */
    public function nguoiDung()
    {
        // Giả sử MaNguoiDung có thể tham chiếu tới GiangVien hoặc SinhVien
        return $this->morphTo(null, 'VaiTro', 'MaNguoiDung');
    }

    /**
     * Phương thức để mã hóa mật khẩu trước khi lưu
     */
    public function setMatKhauAttribute($value)
    {
        $this->attributes['MatKhau'] = bcrypt($value); // Mã hóa mật khẩu với bcrypt
    }

    /**
     * Phương thức kiểm tra vai trò
     */
    public function isRole($role)
    {
        return $this->VaiTro === $role;
    }
}

