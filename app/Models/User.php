<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
    protected $fillable = [
    
        'name',
        'email',
        'password',
    ];
    public function getValidationRules()
    {
        return [
          
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:8',
        ];
    }
}
