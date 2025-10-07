<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorcycleController;

Route::resource('motorcycles', MotorcycleController::class);
Route::get('/', function () {
    return view('welcome');
});
