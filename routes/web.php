<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Models\City;

Route::get('/', function() {
    $cities = \App\Models\City::all();
    return view('index', compact('cities'));
})->name('home');

Route::resource('cities', CityController::class);