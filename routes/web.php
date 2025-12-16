<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Models\City;

Route::get('/', function() {
    return redirect('/cities');
});
Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');
Route::get('/users/{user:name}/cities', [CityController::class, 'index'])->name('users.cities');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::middleware(['auth'])->group(function () {
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}/destroy', [CityController::class, 'destroy'])->name('cities.destroy');    
    Route::post('/cities/{city}/restore', [CityController::class, 'restore'])->name('cities.restore'); 
    Route::delete('/cities/{city}/purge', [CityController::class, 'purge'])->name('cities.purge');   
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/test-route', [CityController::class, 'create'])->name('cities.create');
require __DIR__.'/auth.php';
