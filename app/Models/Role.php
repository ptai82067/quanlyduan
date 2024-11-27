<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'RoleID';
    protected $fillable = [
    
        'name',
        'description'
    ];
    public $timestamps = false; // Tắt timestamps
    public function permissions()
{
    return $this->belongsToMany(Permission::class, 'RolePermissions', 'RoleID', 'PermissionID');
}

    public static function getValidationRules()
    {
        return [
          
            'name' => 'required|string|min:3',  // Nếu 'name' bắt buộc phải có
            'description' => 'nullable|string',
        ];
    }
}

