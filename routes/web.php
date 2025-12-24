<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController;
use App\Models\City;

Route::get('/', function() {
    return redirect('/cities');
});

Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/users/{user:name}/cities', [CityController::class, 'index'])->name('users.cities');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user:name}/feed', [UserController::class, 'feed'])->name('users.feed');

Route::middleware(['auth'])->group(function () {
    Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}/destroy', [CityController::class, 'destroy'])->name('cities.destroy');    
    Route::post('/cities/{city}/restore', [CityController::class, 'restore'])->name('cities.restore'); 
    Route::delete('/cities/{city}/purge', [CityController::class, 'purge'])->name('cities.purge');   
    Route::patch('/users/{user}/toggle-admin', [UserController::class, 'toggle_admin'])
        ->name('users.toggle-admin');
    Route::delete('/users/{user}/destroy', [UserController::class, 'destroy'])
        ->name('users.destroy');
    Route::post('/users/{user:name}/befriend', [UserController::class, 'befriend'])
        ->name('users.befriend');
    Route::post('/users/{user:name}/unfriend', [UserController::class, 'unfriend'])
        ->name('users.unfriend');
});
Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');


Route::get('/cities/{city}/comments', [CommentController::class, 'index'])->name('comments.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/cities/{city}/comments/create', [CommentController::class, 'create'])->name('comments.create');    
    Route::post('/cities/{city}/comments', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
