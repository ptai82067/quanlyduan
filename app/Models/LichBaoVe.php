<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichBaoVe extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'LichBaoVe';
    protected $primaryKey = 'MaLichBaoVe';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaDoAn',
        'ThoiGian',
        'DiaDiem',
        'MaHoiDong',
    ];
    protected $hidden = [
        'MaDoAn'];
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
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'MaDoAn' => 'required|exists:DoAn,MaDoAn', // Phải tồn tại trong bảng DoAn
            'ThoiGian' => 'required|date', // Thời gian phải là một ngày hợp lệ
            'DiaDiem' => 'required|string|max:191', // Địa điểm không được để trống, tối đa 191 ký tự
            'MaHoiDong' => 'nullable|string|max:191', // Mã hội đồng có thể rỗng, tối đa 191 ký tự
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['doAn'];
    }
}
