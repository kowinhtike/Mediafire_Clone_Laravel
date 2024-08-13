<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//to make uuid change uuid("id")->primary() ,model must have HasUuids and all foregin key as foreignUuid()
// note check all froeginid is or not foreginUuid() in the whole user migrations file
// reference from https://laraveldaily.com/post/laravel-users-table-change-primary-key-id-to-uuid
// 1|QjjFPJjqUQwSoRtQmDJUjZfkdiS8KCPkuDluGcxxd1bf1fcd
// "9cbb1fc4-3349-4b12-be47-efac393bfa1f",

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users',function(){
    return User::all();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/folders', [FolderController::class, 'index']);
    Route::post('/folders', [FolderController::class, 'create']);
    Route::get('/folders/{id}', [FolderController::class, 'show']);
    Route::put('/folders/{id}', [FolderController::class, 'update']);
    Route::delete('/folders/{id}', [FolderController::class, 'destroy']);
    Route::get('/folders/{id}/files', [FileController::class, 'index']);
    Route::post('/folders/{id}/files', [FileController::class, 'create']);
    Route::get('/folders/{id}/files/{number}', [FileController::class, 'show']);
    Route::delete('/folders/{id}/files/{number}', [FileController::class, 'destroy']);
    Route::post('/folders/{id}/files/{number}', [FileController::class, 'update']);
});
