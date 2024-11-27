<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'permissions';

    // Khóa chính của bảng
    protected $primaryKey = 'PermissionID';

    // Các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'PermissionName',
    ];

    // Tắt timestamps nếu không sử dụng `created_at` và `updated_at`
    public $timestamps = false;

    /**
     * Quy tắc xác thực khi thêm hoặc cập nhật dữ liệu
     */
    public static function getValidationRules()
    {
        return [
            'PermissionName' => 'required|string|max:255', // Tên quyền hạn là bắt buộc, dạng chuỗi, tối đa 255 ký tự
        ];
    }

    /**
     * Quan hệ với bảng Role.
     * Một quyền hạn có thể thuộc về nhiều vai trò.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'RolePermissions', 'PermissionID', 'RoleID');
    }

    /**
     * Quan hệ liên quan được load mặc định.
     */
    public static function relationsToLoad()
    {
        return ['roles']; // Tự động load thông tin các vai trò khi truy vấn quyền hạn
    }
}
