<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman Akses Terbuka)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Protected Routes (Harus Login / Auth Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // --- DASHBOARD PENGGUNA ---
    Route::get('/dashboard', [QuizController::class, 'dashboard'])->name('dashboard');

    // --- GAME ENGINE QURANQUIZ ---
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::post('/start', [QuizController::class, 'start'])->name('start');       // quiz.start
        Route::get('/question', [QuizController::class, 'show'])->name('show');       // quiz.show
        Route::post('/submit', [QuizController::class, 'store'])->name('submit');     // quiz.submit
        Route::get('/summary', [QuizController::class, 'summary'])->name('summary');  // quiz.summary
    });

    // --- LEADERBOARD ---
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // --- CHATBOT ---
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

    // --- PROFIL PENGGUNA (BREEZE) ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- MANAJEMEN ADMIN ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
        Route::get('/rekap-nilai', [AdminController::class, 'rekapNilai'])->name('rekap.nilai');
    });
});

require __DIR__.'/auth.php';