<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\PemilihVotingController;
use App\Http\Controllers\Auth\PemilihAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('test', [Controller::class, 'x']); // Route untuk testing

// Pemilih Authentication Routes
Route::prefix('pemilih')->middleware('guest')->group(function () {
    Route::get('/login', [PemilihAuthController::class, 'showLoginForm'])->name('pemilih.login');
    Route::post('/login', [PemilihAuthController::class, 'login']);
});
Route::post('/logout', [PemilihAuthController::class, 'logout'])->name('pemilih.logout');

// Manual Admin Authentication Routes (tanpa Auth::routes())
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/admin/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Protected Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Calon Management
    Route::resource('calon', CalonController::class);

    // Pemilih Management
    Route::resource('pemilih', PemilihController::class);

    // Real-time Results
    Route::get('/results', [AdminController::class, 'results'])->name('admin.results');
    Route::get('/results-data', [AdminController::class, 'getResultsData'])->name('admin.results.data'); // Pastikan ini ada

});
Route::get('/pemilih/data', [PemilihController::class, 'getPemilih'])->name('get.pemilih');

// Pemilih Protected Routes
Route::middleware(['pemilih', 'auth'])->prefix('pemilih')->group(function () {
    Route::get('/dashboard', [PemilihVotingController::class, 'dashboard'])->name('pemilih.dashboard');
    Route::get('/profile', [PemilihVotingController::class, 'profile'])->name('pemilih.profile');
    Route::get('/voting', [PemilihVotingController::class, 'voting'])->name('pemilih.voting');
    Route::post('/vote/{calon}', [PemilihVotingController::class, 'vote'])->name('pemilih.vote');
    Route::get('/thanks', [PemilihVotingController::class, 'thanks'])->name('pemilih.thanks');
});

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
