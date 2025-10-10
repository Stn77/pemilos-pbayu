<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\Data\Pemilih;
use App\Http\Controllers\Data\VotingController;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\PemilihVotingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('test', [Controller::class, 'x']); // Route untuk testing

Route::prefix('login')->controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/', 'loginPage')->name('login');
    Route::post('/s', 'loginSubmit')->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/results', [VotingController::class, 'results'])->name('admin.results');
    Route::get('/results-data', [VotingController::class, 'getResultsData'])->name('admin.results.data'); // Pastikan ini ada

    Route::controller(Pemilih::class)->group(function () {
        Route::get('pemilih-data', 'getPemilih')->name('get.pemilih');
        Route::get('/pemilih', 'datapemilih')->name('pemilih.index');
    });

    Route::resource('calon', CalonController::class);

});
// Route::get('/pemilih/data', [Pemilih::class, 'getPemilih'])->name('get.pemilih');

Route::prefix('pemilih')->middleware(['role:pemilih', 'auth'])->group(function () {
    Route::get('/dashboard', [Pemilih::class, 'index'])->name('pemilih.dashboard');
    Route::get('/voting', [Pemilih::class, 'voting'])->name('pemilih.voting');
    Route::get('/profile', [Pemilih::class, 'profile'])->name('pemilih.profile');
    Route::post('/vote/{calon}', [VotingController::class, 'vote'])->name('pemilih.vote');
    Route::get('/thanks', [Pemilih::class, 'thanks'])->name('pemilih.thanks');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Protected Routes
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//     // Calon Management

//     // Pemilih Management
//     Route::resource('pemilih', PemilihController::class);

//     // Real-time Results
//     Route::get('/results', [AdminController::class, 'results'])->name('admin.results');
//     Route::get('/results-data', [AdminController::class, 'getResultsData'])->name('admin.results.data'); // Pastikan ini ada

// });


// Pemilih Protected Routes
// Route::middleware(['role:pemilih', 'auth'])->prefix('pemilih')->group(function () {
//     Route::get('/dashboard', [PemilihVotingController::class, 'dashboard'])->name('pemilih.dashboard');
// });

// Home route
