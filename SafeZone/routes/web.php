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
use App\Http\Controllers\User\EmergencyRouteController;
use App\Http\Controllers\User\DisasterDataController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ShelterController;



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
    Route::get('/emergency-routes', [EmergencyRouteController::class, 'index'])->name('emergency-routes.index');
    Route::post('/emergency-routes/find-nearest', [EmergencyRouteController::class, 'findNearest'])->name('emergency-routes.find-nearest');
    
    // Disaster Monitoring
    Route::get('/disaster-monitor', function () {
        return view('user.disaster-monitor-location');
    })->name('disaster-monitor');
    
    // Disaster Data APIs
    Route::get('/api/disasters/earthquakes', [DisasterDataController::class, 'getEarthquakes'])->name('api.disasters.earthquakes');
    Route::get('/api/disasters/nasa-events', [DisasterDataController::class, 'getNASAEvents'])->name('api.disasters.nasa-events');
    Route::get('/api/disasters/dashboard', [DisasterDataController::class, 'getDashboardData'])->name('api.disasters.dashboard');
    Route::post('/api/disasters/analyze-location', [DisasterDataController::class, 'analyzeLocationDisasters'])->name('api.disasters.analyze-location');
    
    // Notification API
    Route::get('/api/notifications/unread-count', function () {
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count()
        ]);
    });
    
    Route::get('/api/notifications/list', function () {
        $notifications = Auth::user()->unreadNotifications()->take(5)->get();
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    });
    
    Route::post('/api/notifications/{id}/mark-read', function ($id) {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    });
    
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
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Statistics
    Route::get('/statistics', [AdminDashboard::class, 'statistics'])->name('statistics');

    // Shelter management
    Route::get('/shelters', [ShelterController::class, 'index'])->name('shelters.index');
    Route::get('/shelters/create', [ShelterController::class, 'create'])->name('shelters.create');
    Route::post('/shelters', [ShelterController::class, 'store'])->name('shelters.store');
    Route::get('/shelters/{id}/edit', [ShelterController::class, 'edit'])->name('shelters.edit');
    Route::put('/shelters/{id}', [ShelterController::class, 'update'])->name('shelters.update');
    Route::delete('/shelters/{id}', [ShelterController::class, 'destroy'])->name('shelters.destroy');
});

require __DIR__.'/auth.php';
