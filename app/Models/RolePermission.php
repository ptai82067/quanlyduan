<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'Rolepermissions';
    protected $primaryKey = 'RolePermissionID';
    public $timestamps = false;

    protected $fillable = [
        'RoleID',
        'PermissionID',
    ];

    public static function getValidationRules()
    {
        return [
            'RoleID' => 'required|exists:Roles,RoleID',
            'PermissionID' => 'required|exists:Permissions,PermissionID',
        ];
    }

    /**
     * Quan hệ với bảng Role.
     * Một RolePermission thuộc về nhiều Role.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'RolePermissions', 'RoleID', 'PermissionID');
    }

    /**
     * Quan hệ với bảng Permission.
     * Một RolePermission thuộc về nhiều Permission.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'RolePermissions', 'RoleID', 'PermissionID');
    }
    public static function relationsToLoad()
    {
        return ['roles', 'permissions'];
    }
}

