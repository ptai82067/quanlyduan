<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'ThongBao';
    protected $primaryKey = 'MaThongBao';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TieuDe',
        'NoiDung',
        'NgayTao',
        'MaNguoiTao',
        'EmailNguoiNhan',
    ];
    protected $hidden = [
        'MaGiangVien'];
    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bảng GiangVien
     */
    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiTao', 'MaGiangVien');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'TieuDe' => 'required|string|max:191', // Tiêu đề không được để trống, tối đa 191 ký tự
            'NoiDung' => 'required|string', // Nội dung không được để trống
            'NgayTao' => 'required|date', // Ngày tạo phải là một ngày hợp lệ
            'MaNguoiTao' => 'required|exists:GiangVien,MaGiangVien', // Phải tồn tại trong bảng GiangVien
            'EmailNguoiNhan' => 'required|email|max:191', // Email người nhận phải là định dạng email hợp lệ, tối đa 191 ký tự
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['giangVien'];
    }
}
