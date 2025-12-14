<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Models\City;
use App\Models\User;

Route::get('/', [CityController::class, 'index'])->name('home');

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
    $cities = City::with('user')->latest()->get();
    return view('admin.cities', compact('cities'));
})->name('admin.cities')->middleware(['auth', 'admin']);

Route::get('/users/{user:name}/cities', [CityController::class, 'indexByUser'])->name('users.cities');