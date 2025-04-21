<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('action-login', [AuthController::class, 'actionLogin']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', UserRoleController::class);
});
