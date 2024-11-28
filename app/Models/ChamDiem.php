<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamDiem extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'ChamDiem';
    protected $primaryKey = 'MaChamDiem';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaDoAn',
        'MaGiangVien',
        'Diem',
        'NhanXet',
        'NgayChamDiem',
    ];
    protected $hidden = [
        'MaDoAn',
        'MaGiangVien'];

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
            'MaGiangVien' => 'required|exists:GiangVien,MaGiangVien', // Phải tồn tại trong bảng GiangVien
            'Diem' => 'required|numeric|min:0|max:10', // Điểm phải là số trong khoảng từ 0 đến 10
            'NhanXet' => 'nullable|string|max:191', // Nhận xét có thể rỗng, tối đa 191 ký tự
            'NgayChamDiem' => 'required|date', // Ngày chấm điểm phải là ngày hợp lệ
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['doAn', 'giangVien'];
    }
}

