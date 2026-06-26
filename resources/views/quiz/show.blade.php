@extends('layouts.app')
@section('title', 'Pertanyaan Kuis - QuranQuiz')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Progress Bar & Nomor Soal -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-success">Soal {{ $currentNumber }} dari {{ $totalQuestions }}</span>
                <span class="badge bg-success">Waktu Berjalan...</span>
            </div>
            <div class="progress mb-4" style="height: 8px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($currentNumber / $totalQuestions) * 100 }}%"></div>
            </div>

            <!-- Kartu Pertanyaan -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body p-4 text-center">
                    <span class="badge bg-success-subtle text-success mb-3 px-3 py-2 rounded-pill fw-bold">
                        QS. {{ $question->surah_name }} [Surah Ke-{{ $question->surah_number }}]: Ayat {{ $question->ayat_number }}
                    </span>
                    <!-- Teks Ayat / Pertanyaan -->
                    <h3 class="fw-bold text-dark my-3 lh-base" style="font-family: 'Amiri', serif;">
                        {{ $question->ayat_text }}
                    </h3>
                    <p class="text-muted small">Pilihlah jawaban kelanjutan ayat atau terjemahan yang paling tepat di bawah ini!</p>
                </div>
            </div>

            <!-- Form Pilihan Jawaban -->
            <form action="{{ route('quiz.submit') }}" method="POST">
                @csrf
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Opsi A -->
                    <label class="option-container p-3 bg-white rounded-3 shadow-sm d-flex align-items-center border cursor-pointer">
                        <input type="radio" name="answer" value="a" class="form-check-input me-3" required>
                        <div class="fw-semibold text-dark">
                            <span class="badge bg-light text-secondary me-2">A</span> {{ $question->option_a }}
                        </div>
                    </label>

                    <!-- Opsi B -->
                    <label class="option-container p-3 bg-white rounded-3 shadow-sm d-flex align-items-center border cursor-pointer">
                        <input type="radio" name="answer" value="b" class="form-check-input me-3">
                        <div class="fw-semibold text-dark">
                            <span class="badge bg-light text-secondary me-2">B</span> {{ $question->option_b }}
                        </div>
                    </label>

                    <!-- Opsi C -->
                    <label class="option-container p-3 bg-white rounded-3 shadow-sm d-flex align-items-center border cursor-pointer">
                        <input type="radio" name="answer" value="c" class="form-check-input me-3">
                        <div class="fw-semibold text-dark">
                            <span class="badge bg-light text-secondary me-2">C</span> {{ $question->option_c }}
                        </div>
                    </label>

                    <!-- Opsi D -->
                    <label class="option-container p-3 bg-white rounded-3 shadow-sm d-flex align-items-center border cursor-pointer">
                        <input type="radio" name="answer" value="d" class="form-check-input me-3">
                        <div class="fw-semibold text-dark">
                            <span class="badge bg-light text-secondary me-2">D</span> {{ $question->option_d }}
                        </div>
                    </label>

                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                        Berikutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Efek interaktif pas opsi pilihan disorot/diklik */
    .option-container {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .option-container:hover {
        background-color: #f8fff9 !important;
        border-color: #198754 !important;
        transform: translateY(-1px);
    }
    .form-check-input:checked + div {
        color: #198754 !important;
    }
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
</style>
@endsection