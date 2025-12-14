<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Models\City;

Route::get('/', function() {
    return redirect('/cities');
});

Route::resource('cities', CityController::class);