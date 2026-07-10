<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuranQuiz - Cerdas Cermat Islami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1b5e20, #4caf50); min-height: 100vh; color: white; }
        .hero { display: flex; align-items: center; justify-content: center; min-height: 100vh; text-align: center; }
    </style>
</head>
<body>
    <div class="hero">
        <div class="px-3">
            <i class="fa-solid fa-book-quran fa-4x mb-3 text-warning"></i>
            <h1 class="fw-bold display-4">QuranQuiz</h1>
            <p class="lead">Aplikasi Cerdas Cermat Islami — Tebak Terjemahan Ayat</p>
            <p class="text-white-50 mb-4">Uji wawasan Al-Qur'anmu lewat kuis interaktif berbasis ayat acak!</p>
            
            <!-- Deteksi Status Login User secara Dinamis -->
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @auth
                    <!-- Jika Sudah Login (Mengarahkan ke Route Dashboard Utama) -->
                    <a href="{{ route('dashboard') }}" class="btn btn-warning btn-lg fw-bold shadow-sm px-4">
                        <i class="fa-solid fa-gauge me-2"></i>Masuk ke Dashboard Kuis
                    </a>
                @else
                    <!-- Jika Belum Login -->
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg fw-bold px-4">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg fw-bold px-4">
                            <i class="fa-solid fa-user-plus me-2"></i>Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</body>
</html>