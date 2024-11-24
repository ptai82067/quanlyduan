<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoSoBaoVe extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'HoSoBaoVe';
    protected $primaryKey = 'MaHoSo';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaDoAn',
        'TenHoSo',
        'LinkHoSo',
        'NgayCapNhat',
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
            'TenHoSo' => 'required|string|max:191', // Tên hồ sơ không được để trống, tối đa 191 ký tự
            'LinkHoSo' => 'required|url|max:191', // Link hồ sơ bắt buộc là URL hợp lệ, tối đa 191 ký tự
            'NgayCapNhat' => 'required|date', // Ngày cập nhật phải là một ngày hợp lệ
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

