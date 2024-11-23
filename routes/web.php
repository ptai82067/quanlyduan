<?php

use App\Events\RecordUpdate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // event(new RecordUpdate(['message' => 'hihihihi']));
    return view('welcome');
});
Route::get('/pusher', function () {
    return view('pusher');
});
