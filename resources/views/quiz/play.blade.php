@extends('layouts.app')
@section('title', 'Sedang Mengerjakan Kuis')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-body">
        <!-- Progress Angka Soal & Timer -->
        <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-secondary">Soal {{ $number }} / {{ $total }}</span>
            <span class="badge bg-danger" id="timerBadge">⏱ <span id="timerCount">{{ $timeLimit }}</span>s</span>
        </div>

        <!-- Progress Bar Visual -->
        <div class="progress mb-3" style="height: 6px;">
            <div class="progress-bar bg-success" style="width: {{ ($number / $total) * 100 }}%"></div>
        </div>

        <!-- Detail Soal (Potongan Ayat Arab / Informasi Surah) -->
        <h5 class="mb-1 text-center font-serif" dir="rtl" style="font-size: 1.8rem; line-height: 2.5rem; background-color: #f8f9fa; padding: 1rem; border-radius: 0.25rem;">
            {{ $question->ayat_text }}
        </h5>
        <p class="text-muted text-center small mb-3">
            QS. {{ $question->surah_name }} [Ayat: {{ $question->ayat_number }}]
        </p>
        <p class="text-secondary small mb-3 text-center">Pilihlah terjemahan arti yang paling tepat untuk ayat di atas:</p>

        <!-- Form Pilihan Ganda -->
        <form method="POST" action="{{ route('quiz.answer') }}" id="answerForm">
            @csrf
            <!-- Hidden input untuk menampung jawaban yang di-klik -->
            <input type="hidden" name="answer" id="selectedAnswer" value="">

            <div class="list-group">
                @foreach (['a', 'b', 'c', 'd'] as $letter)
                    <button type="button"
                            class="list-group-item list-group-item-action option-btn text-start d-flex align-items-center"
                            data-letter="{{ $letter }}">
                        <span class="badge bg-light text-dark border me-3">{{ strtoupper($letter) }}</span>
                        {{ $question->{'option_' . $letter} }}
                    </button>
                @endforeach
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let timeLeft = {{ $timeLimit }};
    const timerEl = document.getElementById('timerCount');
    const form = document.getElementById('answerForm');
    const hiddenInput = document.getElementById('selectedAnswer');

    // Mencegah submit instan, isi value hidden input dulu, baru submit lewat JS
    document.querySelectorAll('.option-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            hiddenInput.value = this.dataset.letter;
            form.submit();
        });
    });

    // Timer Hitung Mundur otomatis
    const interval = setInterval(() => {
        timeLeft--;
        timerEl.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(interval);
            hiddenInput.value = ''; // Jika waktu habis, jawaban kosong (dianggap salah)
            form.submit();
        }
    }, 1000);
</script>
@endsection