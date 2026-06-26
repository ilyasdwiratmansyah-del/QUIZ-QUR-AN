@extends('layouts.app')
@section('title', 'Dashboard Peserta - QuranQuiz')

@section('content')
<div class="container py-4">
    <!-- Ucapan Selamat Datang -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 bg-white rounded-3 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold text-success mb-1">Assalamu'alaikum, {{ auth()->user()->name }}! 👋</h4>
                    <p class="text-muted small mb-0">Selamat datang kembali di panel kuis Anda. Yuk, uji lagi hafalanmu hari ini!</p>
                </div>
                <div>
                    <!-- Tombol Mulai Sekarang -->
                    <form action="{{ route('quiz.start') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg fw-bold px-4 py-2 shadow-sm animate-btn">
                            <i class="fa-solid fa-play me-2"></i> Mulai Kuis Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Kuis Dimainkan -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-3 text-white" style="background: linear-gradient(135deg, #2e7d32, #4caf50);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 text-uppercase small fw-bold mb-1">Total Kuis Dimainkan</h6>
                        <h2 class="fw-bold mb-0">{{ $totalSearches ?? 0 }} <span class="fs-6 fw-normal">Kali</span></h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-gamepad fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skor Terbaik -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-3 text-white" style="background: linear-gradient(135deg, #1565c0, #2196f3);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 text-uppercase small fw-bold mb-1">Skor Terbaik Anda</h6>
                        <h2 class="fw-bold mb-0">{{ $highestScore ?? 100 }} <span class="fs-6 fw-normal">Poin</span></h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-trophy fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peringkat Leaderboard -->
        <div class="col-md-12 col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-white text-dark">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Status Akun</h6>
                        <span class="badge bg-success-subtle text-success border border-success px-2 py-1 small fw-bold">
                            <i class="fa-solid fa-circle-check me-1"></i> Aktif Berstatus User
                        </span>
                    </div>
                    <div class="bg-light rounded-circle p-3 d-flex align-items-center justify-content-center text-success" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efek animasi halus saat tombol di-hover */
    .animate-btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .animate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }
</style>
@endsection