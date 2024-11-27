<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanCongDoAn extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'phancongdoan';
    protected $primaryKey = 'MaPhanCong';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaDoAn',
        'MaSinhVien',
        'MaGiangVien',
        'NgayPhanCong',
        'GhiChu',
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bảng DoAn
     */
    public function doAn()
    {
        return $this->belongsTo(DoAn::class, 'MaDoAn', 'MaDoAn');
    }

    /**
     * Quan hệ với bảng SinhVien
     */
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'MaSinhVien', 'MaSinhVien');
    }

    /**
     * Quan hệ với bảng GiangVien
     */
    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'MaGiangVien', 'MaGiangVien');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'MaDoAn' => 'required|exists:DoAn,MaDoAn', // Phải tồn tại trong bảng DoAn
            'MaSinhVien' => 'required|exists:SinhVien,MaSinhVien', // Phải tồn tại trong bảng SinhVien
            'MaGiangVien' => 'required|exists:GiangVien,MaGiangVien', // Phải tồn tại trong bảng GiangVien
            'NgayPhanCong' => 'required|date', // Phải là ngày hợp lệ
            'GhiChu' => 'nullable|string|max:191', // Có thể rỗng, tối đa 191 ký tự
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    protected $hidden = [
        'MaDoAn',
        'MaSinhVien',
        'MaGiangVien'];
    public static function relationsToLoad()
    {
        return ['doAn', 'sinhVien', 'giangVien'];
    }
}
