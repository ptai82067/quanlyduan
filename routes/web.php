<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('products', [ProductController::class, 'index']); // Lấy danh sách sản phẩm
Route::post('products', [ProductController::class, 'store']); // Tạo sản phẩm mới
Route::get('products/{id}', [ProductController::class, 'show']); // Lấy chi tiết sản phẩm
Route::put('products/{id}', [ProductController::class, 'update']); // Cập nhật sản phẩm
Route::delete('products/{id}', [ProductController::class, 'destroy']); // Xóa sản phẩm

Route::get('/', function () {
    return view('welcome');
});
Route::get('aaa', function () {
    return view('welcome');
});