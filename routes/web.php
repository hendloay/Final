<?php

use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});
//Route::view('front1','front.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
