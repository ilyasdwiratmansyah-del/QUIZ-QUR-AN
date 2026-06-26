@extends('layouts.app')
@section('title', 'Hasil Kuis')

@section('content')
<div class="card shadow-sm mx-auto text-center" style="max-width: 500px;">
    <div class="card-body">
        <i class="fa-solid fa-trophy fa-3x text-warning mb-3"></i>
        <h4>Kuis Selesai!</h4>
        <h1 class="text-success">{{ $result->score }}</h1>
        <p class="text-muted">Skor Kamu</p>

        <div class="row text-start mt-3">
            <div class="col-6">Jawaban Benar</div>
            <div class="col-6">{{ $result->correct_answers }} / {{ $result->total_questions }}</div>
            <div class="col-6">Waktu Pengerjaan</div>
            <div class="col-6">{{ $result->duration_seconds }} detik</div>
        </div>

        <div class="mt-4">
            <a href="{{ route('quiz.index') }}" class="btn btn-success">Main Lagi</a>
            <a href="{{ route('leaderboard.index') }}" class="btn btn-outline-primary">Lihat Leaderboard</a>
        </div>
    </div>
</div>
@endsection