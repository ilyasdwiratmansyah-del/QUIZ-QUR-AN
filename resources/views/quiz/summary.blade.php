@extends('layouts.app')
@section('title', 'Hasil Kuis - QuranQuiz')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            
            <!-- Kartu Hasil Akhir -->
            <div class="card shadow border-0 rounded-3 overflow-hidden mb-4">
                <!-- Header Atas (Dinamis sesuai skor) -->
                <div class="p-4 text-white {{ $result->score >= 70 ? 'bg-success' : 'bg-warning text-dark' }}">
                    <i class="fa-solid {{ $result->score >= 70 ? 'fa-square-check' : 'fa-triangle-exclamation' }} fa-3x mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $result->score >= 70 ? 'Maa Syaa Allah, Hebat!' : 'Ayo Semangat Lagi!' }}</h3>
                    <p class="mb-0 small opacity-75">Kamu telah menyelesaikan 10 pertanyaan kuis hafalan.</p>
                </div>

                <div class="card-body p-5 bg-white">
                    <!-- Lingkaran Skor Besar -->
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle border border-5 {{ $result->score >= 70 ? 'border-success text-success' : 'border-warning text-warning' }} mb-4 shadow-sm" style="width: 140px; height: 140px; background-color: #f8f9fa;">
                        <div>
                            <span class="display-4 fw-bold d-block">{{ $result->score }}</span>
                            <span class="text-uppercase small fw-bold tracking-wider text-muted">Skor</span>
                        </div>
                    </div>

                    <!-- Detail Statistik Ringkas -->
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-start">
                                <small class="text-muted d-block mb-1"><i class="fa-solid fa-circle-check text-success me-1"></i> Benar</small>
                                <span class="fw-bold text-dark fs-5">{{ $result->correct_answers }} / {{ $result->total_questions }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-start">
                                <small class="text-muted d-block mb-1"><i class="fa-solid fa-clock text-primary me-1"></i> Durasi</small>
                                <span class="fw-bold text-dark fs-5">
                                    @if($result->duration_seconds < 60)
                                        {{ $result->duration_seconds }} Detik
                                    @else
                                        {{ floor($result->duration_seconds / 60) }} Menit {{ $result->duration_seconds % 60 }} Detik
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi Navigasi -->
                    <div class="d-grid gap-2">
                        <form action="{{ route('quiz.start') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                <i class="fa-solid fa-rotate-right me-2"></i> Main Kuis Lagi
                            </button>
                        </form>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary fw-bold py-2">
                            <i class="fa-solid fa-house me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection