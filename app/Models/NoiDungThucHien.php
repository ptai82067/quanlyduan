<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoiDungThucHien extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'noidungthuchien';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'SinhVienID', 
        'MoTa', 
        'LinkMauNguon', 
        'TinhTrang', 
        'ThoiGianThucHien', 
        'FileTaoRa', 
        'GhiChu'
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Phương thức để xác định mối quan hệ với model SinhVien.
     */
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'SinhVienID', 'MaSinhVien');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'SinhVienID' => 'required|exists:SinhVien,MaSinhVien', // Mã sinh viên phải tồn tại trong bảng SinhVien
            'MoTa' => 'nullable|string|max:191',                   // Mô tả có thể rỗng, tối đa 191 ký tự
            'LinkMauNguon' => 'nullable|string|max:191',           // Link mẫu nguồn có thể rỗng, tối đa 191 ký tự
            'TinhTrang' => 'required|boolean',                     // Tình trạng phải là boolean (0 hoặc 1)
            'ThoiGianThucHien' => 'required|date',                 // Thời gian thực hiện phải là ngày hợp lệ
            'FileTaoRa' => 'nullable|string|max:191',              // File tạo ra có thể rỗng, tối đa 191 ký tự
            'GhiChu' => 'nullable|string|max:191',                 // Ghi chú có thể rỗng, tối đa 191 ký tự
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    public static function relationsToLoad()
    {
        return ['sinhVien']; // Load thông tin sinh viên khi truy vấn
    }
}
