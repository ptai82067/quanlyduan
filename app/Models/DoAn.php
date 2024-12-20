<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoAn extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'DoAn';
    protected $primaryKey = 'MaDoAn';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'TenDoAn',
        'MoTa',
        'DoKho',
        'MaNguoiTao',
        'MaNguoiDuyet',
        'MaNguoiKhoaDoAn',
        'NgayTao',
        'NgayDuyet',
        'HanMucDK',       // Thêm thuộc tính HanMucDK
        'SoLuongDK',      // Thêm thuộc tính SoLuongDK
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Phương thức để xác định mối quan hệ với bảng TaiLieu.
     */
    public function taiLieu()
    {
        return $this->hasMany(TaiLieu::class, 'MaDoAn', 'MaDoAn');
    }

    /**
     * Quan hệ với giảng viên tạo đề tài (MaNguoiTao).
     */
    public function giangVienTao()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiTao', 'MaGiangVien');
    }

    /**
     * Quan hệ với giảng viên duyệt đề tài (MaNguoiDuyet).
     */
    public function giangVienDuyet()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiDuyet', 'MaGiangVien');
    }

    /**
     * Quan hệ với giảng viên khoa đồ án (MaNguoiKhoaDoAn).
     */
    public function giangVienKhoaDoAn()
    {
        return $this->belongsTo(GiangVien::class, 'MaNguoiKhoaDoAn', 'MaGiangVien');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'TenDoAn' => 'required|string|max:191',
            'MoTa' => 'nullable|string',
            'DoKho' => 'required|integer|min:1|max:10', // Độ khó phải là số nguyên từ 1 đến 10
            'MaNguoiTao' => 'required|exists:GiangVien,MaGiangVien', // Phải tồn tại trong bảng GiangVien
            'MaNguoiDuyet' => 'nullable|exists:GiangVien,MaGiangVien', // Có thể rỗng, nếu có phải tồn tại
            'MaNguoiKhoaDoAn' => 'nullable|exists:GiangVien,MaGiangVien',
            'NgayTao' => 'required|string', // Phải là một ngày hợp lệ
            'NgayDuyet' => 'nullable|string',
            'HanMucDK' => 'nullable|integer|min:0',  // Hạn mức đăng ký có thể rỗng, phải là số nguyên >= 0
            'SoLuongDK' => 'nullable|integer|min:0', // Số lượng đăng ký không vượt quá hạn mức
        ];
    }

    /**
     * Phương thức để load các quan hệ khi truy vấn
     */
    protected $hidden = ['MaNguoiTao','MaNguoiDuyet','MaNguoiKhoaDoAn'];
    public static function relationsToLoad()
    {
        return ['taiLieu', 'giangVienTao', 'giangVienDuyet', 'giangVienKhoaDoAn']; // Load thông tin giảng viên khi truy vấn
    }
}
