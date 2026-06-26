<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page (Halaman Awal)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Halaman Terproteksi Log In (Auth Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard Utama Peserta (Menggunakan QuizController yang menghitung statistik)
    Route::get('/dashboard', [QuizController::class, 'dashboard'])->name('dashboard');

    // --- GAME ENGINE QURANQUIZ ---
    // 1. Tombol Mulai Kuis (Mengacak Soal & Set Session)
    Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
    
    // 2. Halaman Pertanyaan Kuis (Tampil Satu per Satu)
    Route::get('/quiz/question', [QuizController::class, 'show'])->name('quiz.show');
    
    // 3. Tombol Submit Jawaban (Cek Jawaban & Maju ke Soal Berikutnya)
    Route::post('/quiz/submit', [QuizController::class, 'store'])->name('quiz.submit');
    
    // 4. Halaman Hasil Akhir Nilai Kuis (Summary)
    Route::get('/quiz/summary', [QuizController::class, 'summary'])->name('quiz.summary');

    // --- LEADERBOARD / PERINGKAT ---
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // --- MANAJEMEN USER (KHUSUS ADMIN) ---
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    

    // --- PROFIL PENGGUNA (BAWAAN BREEZE) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // Rute Baru Rekap Nilai    
    Route::get('/admin/rekap-nilai', [AdminController::class, 'rekapNilai'])->name('admin.rekap.nilai');
});

require __DIR__.'/auth.php';