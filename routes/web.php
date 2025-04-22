<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('action-login', [AuthController::class, 'actionLogin']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('major', JurusanController::class);
});

Route::resource('instructor', InstructorController::class);

// routes/web.php

Route::middleware('role:admin')->group(function () {
    Route::get('/test', function () {
        return view('hello-world'); // mengembalikan view 'hello-world'
    });
});
