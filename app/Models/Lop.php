<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    protected $table = 'Lop';
    protected $primaryKey = 'MaLop';
    protected $fillable = [
        'TenLop', 
        'MaKhoa',
    ];

    public $timestamps = false;

    public function khoa()
    {
        return $this->belongsTo(Khoa::class, 'MaKhoa', 'MaKhoa');
    }
    protected $hidden = ['MaKhoa'];
    public static function relationsToLoad()
    {
        return ['khoa']; // Load thông tin khoa khi query lớp
    }
     // Quy tắc xác thực
     public static function getValidationRules()
     {
         return [
             'TenLop' => 'required|string|max:191', // Tên lớp không thể trống và không quá 191 ký tự
             'MaKhoa' => 'nullable|exists:Khoa,MaKhoa|integer', // Mã khoa phải tồn tại trong bảng Khoa (nếu có)
         ];
     }
}
