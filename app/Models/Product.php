<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id', 'name', 'description', 'price', 'stock'];
    public function getValidationRules()
    {
        return [
            'mssv' => 'required|unique:sinhvien,mssv',
            'hoten' => 'required|max:255',
            'gioitinh' => 'required|in:Nam,Nu',
            'lop' => 'required|max:10',
            'diachi' => 'nullable|max:255',
        ];
    }
}
