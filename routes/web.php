<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    // Activity log
    Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
});

// Route for test page
Route::get('/test', function () {
    return view('profile.index');
})->name('test');

// blank
Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Permission routes
    Route::resource('permissions', PermissionController::class);

    // Role routes
    Route::resource('roles', RoleController::class);

    // User routes
    Route::resource('users', UserController::class);

    // Activity log
    Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
});

require __DIR__ . '/auth.php';