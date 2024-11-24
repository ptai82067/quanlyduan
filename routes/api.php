<?php

use App\Http\Controllers\DynamicApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DangNhapController;

// Route đăng nhập

Route::post('/dang-nhap', [DangNhapController::class, 'login']);
// Nếu bạn không cần một tiền tố, chỉ cần định nghĩa group mà không cần 'prefix'
// Route::group([], function () {
//     Route::get('{table}', [DynamicApiController::class, 'index']);
//     Route::get('{table}/{id}', [DynamicApiController::class, 'show']);
//     Route::post('{table}', [DynamicApiController::class, 'store']);
//     Route::put('{table}/{id}', [DynamicApiController::class, 'update']);
//     Route::delete('{table}/{id}', [DynamicApiController::class, 'destroy']);
// });
Route::prefix('')->group(function () {
    Route::get('{table}', [DynamicApiController::class, 'index']);
    Route::get('{table}/{id}', [DynamicApiController::class, 'show']);
    Route::post('{table}', [DynamicApiController::class, 'store']);
    Route::put('{table}/{id}', [DynamicApiController::class, 'update']);
    Route::delete('{table}/{id}', [DynamicApiController::class, 'destroy']);

});