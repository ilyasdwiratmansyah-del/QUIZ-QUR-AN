<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Menampilkan Halaman Utama Dashboard User beserta statistiknya
     */
    public function dashboard()
    {
        $userId = auth()->id();
        $totalSearches = QuizResult::where('user_id', $userId)->count();
        $highestScore = QuizResult::where('user_id', $userId)->max('score') ?? 0;

        return view('dashboard', compact('totalSearches', 'highestScore'));
    }

    /**
     * Inisialisasi awal kuis (Mulai Kuis Baru)
     */
    public function start(Request $request)
    {
        // 1. Ambil 10 soal acak dari database
        $questions = Question::inRandomOrder()->take(10)->get();

        if ($questions->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Belum ada soal kuis di database. Silakan hubungi Admin!');
        }

        // 2. Simpan daftar ID soal dan status kuis ke dalam Session Laravel
        $questionIds = $questions->pluck('id')->toArray();
        
        session([
            'quiz_questions' => $questionIds,
            'quiz_current_index' => 0, // Mulai dari soal pertama (index 0)
            'quiz_correct_answers' => 0,
            'quiz_start_time' => now(), // Catat waktu mulai untuk menghitung durasi nanti
            'quiz_answers' => [] // Menyimpan riwayat jawaban user
        ]);

        return redirect()->route('quiz.show');
    }

    /**
     * Tampilkan soal satu per satu berdasarkan index session
     */
    public function show()
    {
        // Proteksi jika user mencoba masuk langsung tanpa klik tombol "Mulai"
        if (!session()->has('quiz_questions')) {
            return redirect()->route('dashboard')->with('error', 'Silakan klik tombol Mulai Kuis Terlebih dahulu!');
        }

        $questionIds = session('quiz_questions');
        $currentIndex = session('quiz_current_index');

        // Jika semua soal sudah dijawab (index mencapai 10), arahkan ke simpan hasil
        if ($currentIndex >= count($questionIds)) {
            return $this->finishQuiz();
        }

        // Ambil data soal saat ini berdasarkan ID yang disimpan di session
        $currentQuestionId = $questionIds[$currentIndex];
        $question = Question::findOrFail($currentQuestionId);

        return view('quiz.show', [
            'question' => $question,
            'currentNumber' => $currentIndex + 1,
            'totalQuestions' => count($questionIds)
        ]);
    }

    /**
     * Proses memeriksa jawaban user dan lanjut ke soal berikutnya
     */
    public function store(Request $request)
    {
        $request->validate([
            'answer' => 'required|in:a,b,c,d'
        ]);

        $questionIds = session('quiz_questions');
        $currentIndex = session('quiz_current_index');

        $currentQuestionId = $questionIds[$currentIndex];
        $question = Question::findOrFail($currentQuestionId);

        // 1. Cek apakah jawaban user benar
        $isCorrect = ($request->answer === $question->correct_option);
        
        if ($isCorrect) {
            session()->increment('quiz_correct_answers');
        }

        // 2. Simpan riwayat jawaban ke session (opsional, berguna untuk review)
        $quizAnswers = session('quiz_answers', []);
        $quizAnswers[$currentQuestionId] = $request->answer;
        session(['quiz_answers' => $quizAnswers]);

        // 3. Naikkan index untuk maju ke soal berikutnya
        session(['quiz_current_index' => $currentIndex + 1]);

        return redirect()->route('quiz.show');
    }

    /**
     * Finalisasi: Hitung total waktu, simpan ke DB, dan bersihkan session kuis
     */
    private function finishQuiz()
    {
        $startTime = session('quiz_start_time');
        $durationSeconds = now()->diffInSeconds($startTime);
        
        $totalQuestions = count(session('quiz_questions'));
        $correctAnswers = session('quiz_correct_answers');
        
        // Rumus matematika skor sederhana: (Jawaban Benar / Total Soal) * 100
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Simpan data ke tabel quiz_results
        $result = QuizResult::create([
            'user_id' => auth()->id(),
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score' => $score,
            'duration_seconds' => $durationSeconds,
            'played_at' => now(),
        ]);

        // Simpan ID hasil kuis ke session agar bisa ditampilkan di halaman summary
        session(['last_quiz_result_id' => $result->id]);

        // Bersihkan session data kuis agar tidak bisa di-refresh/ditembak ulang oleh user
        session()->forget(['quiz_questions', 'quiz_current_index', 'quiz_correct_answers', 'quiz_start_time']);

        return redirect()->route('quiz.summary');
    }

    /**
     * Halaman Ringkasan Nilai Akhir Kuis
     */
    public function summary()
    {
        $resultId = session('last_quiz_result_id');
        
        if (!$resultId) {
            return redirect()->route('dashboard');
        }

        $result = QuizResult::findOrFail($resultId);

        return view('quiz.summary', compact('result'));
    }
}