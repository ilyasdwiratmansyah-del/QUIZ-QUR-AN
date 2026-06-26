@extends('layouts.app')
@section('title', 'Mulai Kuis')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 500px;">
    <div class="card-body text-center">
        <i class="fa-solid fa-quran fa-3x text-success mb-3"></i>
        <h4>Tebak Ayat & Tafsir</h4>
        <p class="text-muted">Kamu akan menjawab {{ $requiredQuestions }} soal acak. Setiap soal punya batas waktu, jadi siapkan dirimu!</p>
        <p class="small text-muted">Soal tersedia di database: {{ $availableQuestions }}</p>

        <form method="POST" action="{{ route('quiz.start') }}">
            @csrf
            <button type="submit" class="btn btn-success btn-lg w-100">
                <i class="fa-solid fa-play"></i> Mulai Kuis
            </button>
        </form>
    </div>
</div>
@endsection