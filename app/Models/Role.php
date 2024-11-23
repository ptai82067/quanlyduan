<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
    
        'name',
        'description'
    ];
    public $timestamps = false; // Tắt timestamps
    public static function getValidationRules()
    {
        return [
          
            'name' => 'required|string|min:3',  // Nếu 'name' bắt buộc phải có
            'description' => 'nullable|string',
        ];
    }
}

