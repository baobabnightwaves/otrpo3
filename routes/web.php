<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Models\City;
use App\Models\User;

Route::get('/', function() {
    return redirect('/cities');
});

Route::resource('cities', CityController::class);

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    
    $stats = [
        'my_cities' => $user->cities()->count(),
        'is_admin' => $user->is_admin,
    ];
    
    if ($user->is_admin) {
        $stats['all_cities'] = City::count();
        $stats['all_users'] = User::count();
        $stats['admin_users'] = User::where('is_admin', true)->count();
    }
    
    return view('dashboard', compact('stats'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/admin/cities', function() {
    $cities = City::withTrashed()->with('owner')->latest()->get();
    return view('cities.index', compact('cities'));
})->name('admin.cities')->middleware(['auth', 'admin']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])
        ->name('users.index');
    
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])
        ->name('users.show');
    
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
        ->name('users.edit');
    
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
        ->name('users.update');
    
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
        ->name('users.destroy');
    
    Route::post('/users/{user}/toggle-admin', [App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])
        ->name('users.toggle-admin');
    
    Route::get('/users/{user}/cities', [App\Http\Controllers\Admin\UserController::class, 'userCities'])
        ->name('users.cities');
});

Route::post('/cities/{id}/restore', [CityController::class, 'restore'])
    ->name('cities.restore');