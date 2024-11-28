<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TienDo extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'TienDo';
    protected $primaryKey = 'MaTienDo';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaDoAn',
        'MoTa',
        'TrangThai',
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
            'MoTa' => 'nullable|string|max:191', // Có thể rỗng, tối đa 191 ký tự
            'TrangThai' => 'required|string|max:50', // Trạng thái là chuỗi bắt buộc, tối đa 50 ký tự
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

