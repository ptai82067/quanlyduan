<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $table = 'SinhVien';
    protected $fillable = [
    
        'Ten',
        'age'
    ];
    public $timestamps = false; // Tắt timestamps
    public function getValidationRules()
    {
        return [
          
            'Ten' => 'required|string|max:30',
            'age' => 'required|integer',
        ];
    }
}
