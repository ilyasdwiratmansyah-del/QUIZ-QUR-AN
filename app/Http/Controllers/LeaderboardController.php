<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;

class LeaderboardController extends Controller
{
    public function index()
    {
        $results = QuizResult::with('user')
            ->orderByDesc('score')
            ->orderBy('duration_seconds')
            ->limit(20)
            ->get();

        return view('leaderboard.index', ['results' => $results]);
    }
}