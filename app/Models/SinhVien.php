<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'SinhVien';
    protected $primaryKey = 'MaSinhVien';
    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'HoTen',
        'NgaySinh',
        'GioiTinh',
        'MaLop',
        'Email',
        'SDT',
        'TrangThai',
    ];

    // Tắt timestamps nếu không sử dụng các cột `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Phương thức để xác định mối quan hệ với model Lop.
     */
    public function lop()
    {
        return $this->belongsTo(Lop::class, 'MaLop', 'MaLop');
    }
    protected $hidden = ['MaLop'];
    public static function relationsToLoad()
    {
        return ['lop']; // Load thông tin lớp khi truy vấn sinh viên
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'HoTen' => 'required|string|max:191',     // Họ tên không được rỗng, dạng chuỗi, tối đa 191 ký tự
            'NgaySinh' => 'required|date',           // Ngày sinh không được rỗng, dạng ngày hợp lệ
            'GioiTinh' => 'required|boolean',        // Giới tính không được rỗng, chỉ nhận 0 (Nữ) hoặc 1 (Nam)
            'MaLop' => 'nullable|exists:Lop,MaLop',  // Mã lớp có thể rỗng, nếu có phải tồn tại trong bảng Lop
            'Email' => 'nullable|email|max:191',     // Email có thể rỗng, nếu có phải hợp lệ và tối đa 191 ký tự
            'SDT' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:15', // Số điện thoại có thể rỗng, phải hợp lệ và tối đa 15 ký tự
            'TrangThai' => 'nullable|boolean',       // Trạng thái có thể rỗng, chỉ nhận 0 (Không hoạt động) hoặc 1 (Hoạt động)
        ];
    }
}
