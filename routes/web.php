<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/uploadpage', [HomeController::class, 'uploadpage']);

Route::post('/uploadbook', [HomeController::class, 'store']);

Route::get('/uploadpage', [HomeController::class, 'show']);

Route::get('/managepage', [UserController::class, 'index'])->name('user.manage');

Route::put('/users/{user}', [UserController::class, 'updateUserType'])->name('users.updateUserType');


Route::get('/view/{id}', [HomeController::class, 'view'])->name('view');

Route::get('/download/{file}', [HomeController::class, 'download'])->name('download');

Route::delete('/delete/{id}', [HomeController::class, 'destroy'])->name('delete');





Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('post', [HomeController::class, 'post'])->middleware(['auth', 'admin']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('notes', 'notes')->name('notes');
    Route::view('favorites', 'favorites')->name('favorites');
});



require __DIR__ . '/auth.php';
