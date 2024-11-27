<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'users';

    // Khóa chính của bảng
    protected $primaryKey = 'id';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'MaNguoiDung',
        'Username',
        'PasswordHash', // Chỉnh sửa tên cho chính xác với trường trong cơ sở dữ liệu
        'RoleID',
    ];

    // Tắt timestamps nếu không sử dụng `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quan hệ với bảng Role.
     * Một người dùng thuộc về một vai trò.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'RoleID');
    }

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'MaNguoiDung' => 'required|integer',            // Mã người dùng bắt buộc, là số nguyên
            'Username' => 'required|string|max:255',        // Username không được rỗng, dạng chuỗi, tối đa 255 ký tự
            'PasswordHash' => 'required|string|max:255',    // Mật khẩu đã mã hóa không được rỗng, dạng chuỗi, tối đa 255 ký tự
            'RoleID' => 'required|exists:Roles,RoleID',     // Vai trò bắt buộc phải tồn tại trong bảng Roles
        ];
    }

    /**
     * Quan hệ liên quan được load mặc định.
     */
    public static function relationsToLoad()
    {
        return ['role']; // Tự động load thông tin vai trò khi truy vấn người dùng
    }

    /**
     * Phương thức mã hóa mật khẩu khi tạo mới hoặc cập nhật người dùng
     */
    public function setPasswordHashAttribute($value)
    {
        // Kiểm tra xem giá trị mật khẩu có tồn tại hay không, nếu có thì mã hóa
        if ($value) {
            $this->attributes['PasswordHash'] = bcrypt($value); // Mã hóa mật khẩu với bcrypt
        }
    }

    /**
     * Phương thức kiểm tra vai trò
     */
    public function isRole($role)
    {
        return $this->RoleID === $role;
    }
}
