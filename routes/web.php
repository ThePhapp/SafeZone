<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDashboard;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\AlertUserController;


Route::get('/', [UserDashboard::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create',[AddressController::class, 'createAddressForUser'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'storeAddressForUser'])->name('addresses.store');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/alerts', [AlertUserController::class, 'index'])->name('alerts.index');
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
});

require __DIR__.'/auth.php';
