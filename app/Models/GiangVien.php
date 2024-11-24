<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'GiangVien';
    protected $primaryKey = 'MaGiangVien';
    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'HoTen',
        'Email',
        'SDT',
        'MaBoMon',
        'CanBoKhoa',
    ];

    // Tắt timestamps nếu không sử dụng `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bảng BoMon.
     * Một giảng viên thuộc về một bộ môn.
     */
    public function boMon()
    {
        return $this->belongsTo(BoMon::class, 'MaBoMon', 'MaBoMon');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'HoTen' => 'required|string|max:191',     // Họ tên không được rỗng, dạng chuỗi, tối đa 191 ký tự
            'Email' => 'nullable|email|max:191',     // Email có thể rỗng, phải hợp lệ và tối đa 191 ký tự
            'SDT' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:15', // Số điện thoại có thể rỗng, phải hợp lệ và tối đa 15 ký tự
            'MaBoMon' => 'nullable|exists:BoMon,MaBoMon', // Mã bộ môn có thể rỗng, nếu có phải tồn tại trong bảng BoMon
            'CanBoKhoa' => 'nullable|boolean',       // Cán bộ khoa có thể rỗng, chỉ nhận 0 (Không) hoặc 1 (Có)
        ];
    }

    /**
     * Ẩn trường MaBoMon vì đã có thông tin từ quan hệ `boMon`
     */
    protected $hidden = ['MaBoMon'];

    /**
     * Quan hệ liên quan được load mặc định.
     */
    public static function relationsToLoad()
    {
        return ['boMon']; // Load thông tin bộ môn khi truy vấn giảng viên
    }
}

