<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAPIToken;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/login', 301);

Route::get('login', [AdminController::class, 'login'])->name('login');
Route::get('register', [AdminController::class, 'register'])->name('register');

Route::post('login', [AdminController::class, 'actionLogin'])->name('postLogin');
Route::post('register', [AdminController::class, 'actionRegister'])->name('postRegister');

Route::middleware(['auth.api'])->group(function () {
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('users', [SuperUserController::class, 'index'])->name('users');
    Route::put('users/{id}', [SuperUserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [SuperUserController::class, 'destroy'])->name('users.destroy');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Assets
    // Route::resource('assets', AssetController::class)->scoped(['asset' => 'id',]);
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('assets/{id}', [AssetController::class, 'show'])->where('id', '[0-9]+')->name('assets.show');

    Route::middleware(['assets'])->group(function () {
        Route::get('assets/{id}/edit', [AssetController::class, 'edit'])->where('id', '[0-9]+')->name('assets.edit');
        Route::put('assets/{id}/update', [AssetController::class, 'update'])->where('id', '[0-9]+')->name('assets.update');
        Route::delete('assets/{id}/delete', [AssetController::class, 'destroy'])->where('id', '[0-9]+')->name('assets.destroy');
    });
    Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/create/step1', [BorrowingController::class, 'createStep1'])->name('borrowings.create.step1');
    Route::post('borrowings/store/step1', [BorrowingController::class, 'storeStep1'])->name('borrowing.store.step1');
    Route::get('borrowings/create/step2', [BorrowingController::class, 'createStep2'])->name('borrowings.create.step2');
    Route::post('borrowings/store/step2', [BorrowingController::class, 'storeStep2'])->name('borrowing.store.step2');
    Route::get('borrowings/{id}', [BorrowingController::class, 'show'])->name('borrowings.show');
});
