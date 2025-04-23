<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailModulController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LearningModulController;
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
    Route::resource('learning_module', LearningModulController::class);

    Route::get('learning_module', [LearningModulController::class, 'index'])->name('learning_module.index');
    Route::get('learning_module/{instructor}/create', [LearningModulController::class, 'create'])->name('learning_module.create');

    Route::post('learning_module', [LearningModulController::class, 'store'])->name('learning_module.store');
    Route::get('learning_module/{id}/edit', [LearningModulController::class, 'edit'])->name('learning_module.edit');
    Route::put('learning_module/{id}', [LearningModulController::class, 'update'])->name('learning_module.update');
    Route::delete('learning_module/{id}', [LearningModulController::class, 'destroy'])->name('learning_module.destroy');

    Route::resource('detail_module', DetailModulController::class);
});

Route::resource('instructor', InstructorController::class);

// routes/web.php

Route::middleware('role:admin')->group(function () {
    Route::get('/test', function () {
        return view('hello-world'); // mengembalikan view 'hello-world'
    });
});
