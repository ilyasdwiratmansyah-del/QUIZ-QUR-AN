<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        // Proteksi jika API Key belum dipasang di .env
        if (!$apiKey) {
            return response()->json(['answer' => 'Error: GEMINI_API_KEY belum dikonfigurasi di file .env'], 500);
        }

        $prompt = "Kamu adalah asisten AI yang ahli dalam Al-Qur'an dan tafsir Islam. Jawab pertanyaan berikut dengan bahasa Indonesia yang mudah dipahami, singkat, dan akurat berdasarkan Al-Qur'an dan hadits. Pertanyaan: {$userMessage}";

        try {
            // Jalur resmi Free Tier paling aman & stabil saat ini
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

            // Jika API Google Gemini memberikan respons error
            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json([
                    'answer' => 'Gagal menghubungi AI Google. Detail: ' . ($response->json()['error']['message'] ?? 'Unknown Error')
                ], $response->status());
            }

            $data = $response->json();
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, tidak ada jawaban tersedia.';

            // WAJIB menggunakan 'answer' agar singkron dengan JavaScript (data.answer) di app.blade.php
            return response()->json(['answer' => $answer]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'answer' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}