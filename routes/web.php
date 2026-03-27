<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Public Poems
use App\Http\Controllers\PoemController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

Route::get('/poems', [PoemController::class, 'index'])->name('poems.index');
Route::get('/poems/{slug}', [PoemController::class, 'show'])->name('poems.show');

// Public Authors & Categories
use App\Http\Controllers\Social\DiscoveryController;
use App\Http\Controllers\Social\FollowController;

Route::get('/penyair/{username}', [AuthorController::class, 'show'])->name('authors.show');
Route::post('/authors/{user}/follow', [FollowController::class, 'follow'])->name('authors.follow')->middleware('auth');
Route::post('/authors/{user}/unfollow', [FollowController::class, 'unfollow'])->name('authors.unfollow')->middleware('auth');
Route::get('/penyair', [DiscoveryController::class, 'writers'])->name('writers.index');
Route::get('/feed', [DiscoveryController::class, 'feed'])->name('feed.index')->middleware('auth');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

use App\Http\Controllers\Dashboard\PoemController as DashboardPoemController;

use App\Http\Controllers\Dashboard\ProfileController;

use App\Http\Controllers\Dashboard\DashboardController;

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::post('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');

    Route::resource('dashboard/poems', DashboardPoemController::class)->names([
        'index' => 'dashboard.poems.index',
        'create' => 'dashboard.poems.create',
        'store' => 'dashboard.poems.store',
        'show' => 'dashboard.poems.show',
        'edit' => 'dashboard.poems.edit',
        'update' => 'dashboard.poems.update',
        'destroy' => 'dashboard.poems.destroy',
    ]);
});

// Admin Routes
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('users', AdminUserController::class)->only(['index', 'update', 'destroy']);
    
    // Add Tag management if needed later
});
