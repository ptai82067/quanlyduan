<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongKeBaiViet extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'ThongKeBaiViet';
    protected $primaryKey = 'MaThongKe';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaBaiViet',
        'SoLuotXem',
        'SoBinhLuan',
    ];
    protected $hidden = ['MaBaiViet'];
    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'MaBaiViet' => 'required|exists:BaiViet,MaBaiViet', // Phải tồn tại trong bảng BaiViet
            'SoLuotXem' => 'required|integer|min:0', // Số lượt xem, bắt buộc và phải là số nguyên không âm
            'SoBinhLuan' => 'required|integer|min:0', // Số bình luận, bắt buộc và phải là số nguyên không âm
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
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['baiViet']; // Load thông tin bài viết khi truy vấn
    }
}
