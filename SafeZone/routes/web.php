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

Route::get('/dashboard', [UserDashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create',[AddressController::class, 'createAddressForUser'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'storeAddressForUser'])->name('addresses.store');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/alerts', [AlertUserController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/load', [AlertController::class, 'loadMore'])->name('alerts.load');
    Route::get('/alerts/{id}', [AlertUserController::class, 'show'])->name('alerts.show'); 
    
    // Emergency Routes
    Route::get('/emergency-routes', [\App\Http\Controllers\User\EmergencyRouteController::class, 'index'])->name('emergency-routes.index');
    Route::post('/emergency-routes/find-nearest', [\App\Http\Controllers\User\EmergencyRouteController::class, 'findNearest'])->name('emergency-routes.find-nearest');
    
    // Disaster Monitoring
    Route::get('/disaster-monitor', function () {
        return view('user.disaster-monitor-location');
    })->name('disaster-monitor');
    
    // Disaster Data APIs
    Route::get('/api/disasters/earthquakes', [\App\Http\Controllers\User\DisasterDataController::class, 'getEarthquakes'])->name('api.disasters.earthquakes');
    Route::get('/api/disasters/nasa-events', [\App\Http\Controllers\User\DisasterDataController::class, 'getNASAEvents'])->name('api.disasters.nasa-events');
    Route::get('/api/disasters/dashboard', [\App\Http\Controllers\User\DisasterDataController::class, 'getDashboardData'])->name('api.disasters.dashboard');
    Route::post('/api/disasters/analyze-location', [\App\Http\Controllers\User\DisasterDataController::class, 'analyzeLocationDisasters'])->name('api.disasters.analyze-location');
    
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
    Route::get('/alerts/{id}', [AlertController::class, 'show'])->name('alerts.show');
    Route::get('/alerts/{id}/edit', [AlertController::class, 'edit'])->name('alerts.edit');
    Route::put('/alerts/{id}', [AlertController::class, 'update'])->name('alerts.update');
    Route::get('/alerts/{id}/delete', [AlertController::class, 'destroy'])->name('alerts.delete');

    // User management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Statistics
    Route::get('/statistics', [\App\Http\Controllers\Admin\AdminDashboard::class, 'statistics'])->name('statistics');

    // Shelter management
    Route::get('/shelters', [\App\Http\Controllers\Admin\ShelterController::class, 'index'])->name('shelters.index');
    Route::get('/shelters/create', [\App\Http\Controllers\Admin\ShelterController::class, 'create'])->name('shelters.create');
    Route::post('/shelters', [\App\Http\Controllers\Admin\ShelterController::class, 'store'])->name('shelters.store');
    Route::get('/shelters/{id}/edit', [\App\Http\Controllers\Admin\ShelterController::class, 'edit'])->name('shelters.edit');
    Route::put('/shelters/{id}', [\App\Http\Controllers\Admin\ShelterController::class, 'update'])->name('shelters.update');
    Route::delete('/shelters/{id}', [\App\Http\Controllers\Admin\ShelterController::class, 'destroy'])->name('shelters.destroy');
});

require __DIR__.'/auth.php';
