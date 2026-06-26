@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')
<h4 class="mb-3"><i class="fa-solid fa-ranking-star text-warning"></i> Papan Peringkat</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Skor</th>
                    <th>Benar</th>
                    <th>Waktu (detik)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $i => $result)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $result->user->name }}</td>
                        <td><span class="badge bg-success">{{ $result->score }}</span></td>
                        <td>{{ $result->correct_answers }}/{{ $result->total_questions }}</td>
                        <td>{{ $result->duration_seconds }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada yang bermain kuis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection