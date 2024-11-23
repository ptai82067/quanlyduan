<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
    
        'name',
        'email',
        'password',
        'role_id'
    ];
    public $timestamps = false; // Tắt timestamps
    public static function getValidationRules()
    {
        return [
          
            'name' => 'required|string|max:191', // name không thể trống, là chuỗi và không quá 191 ký tự
            'email' => 'required|email|unique:users,email|max:191', // email phải hợp lệ, duy nhất trong bảng 'users'
            'password' => 'required|string|min:8', // password không thể trống, là chuỗi và tối thiểu 8 ký tự
            'role_id' => 'required|exists:roles,id|integer',
        ];
    }
}

