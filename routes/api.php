<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DynamicAPIController;
Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'API working!']);
    });

});

Route::get('{table}', [DynamicAPIController::class, 'index']);
Route::get('{table}/{id}', [DynamicAPIController::class, 'show']);
Route::post('{table}', [DynamicAPIController::class, 'store']);
Route::put('{table}/{id}', [DynamicAPIController::class, 'update']);
Route::delete('{table}/{id}', [DynamicAPIController::class, 'destroy']);

