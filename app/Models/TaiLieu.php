<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'TaiLieu';
    protected $primaryKey = 'MaTaiLieu';
    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TenTaiLieu',
        'LinkTaiLieu',
        'MaDoAn',
    ];
    protected $hidden = ['MaDoAn'];
    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Phương thức để xác định mối quan hệ với bảng DoAn.
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
            'TenTaiLieu' => 'required|string|max:191',
            'LinkTaiLieu' => 'required|string|max:191|url', // Link phải là URL hợp lệ
            'MaDoAn' => 'required|exists:DoAn,MaDoAn', // Phải tồn tại trong bảng DoAn
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['doAn']; // Load thông tin đồ án liên quan khi truy vấn
    }
}
