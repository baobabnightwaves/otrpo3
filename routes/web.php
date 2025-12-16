<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Models\City;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/cities');
});

Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');
Route::get('/users/{user:name}/cities', [CityController::class, 'index'])->name('users.cities');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');    
    Route::post('/cities/{city}/restore', [CityController::class, 'restore'])->name('cities.restore');    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'can:access-admin-panel'])->group(function () {
    Route::delete('/cities/{city}/purge', [CityController::class, 'purge'])->name('cities.purge');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
