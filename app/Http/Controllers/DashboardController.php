<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $totalQuiz = $user->quizResults()->count();
        $bestScore = $user->quizResults()->max('score') ?? 0;

        return view('dashboard', [
            'totalQuiz' => $totalQuiz,
            'bestScore' => $bestScore,
        ]);
    }
}