<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Middleware\CheckAPIToken;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/login', 301);

Route::get('login', [AdminController::class, 'login'])->name('login');

Route::post('login', [AdminController::class, 'actionLogin'])->name('postLogin');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Assets
Route::get('assets/', [AssetController::class, 'index'])->name('assets');
Route::get('assets/{id}', [AssetController::class, 'show'])->where('id', '[0-9]+')->name('assets.details');
