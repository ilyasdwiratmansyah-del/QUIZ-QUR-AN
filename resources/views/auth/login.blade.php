@extends('layouts.app')
@section('title', 'Login - QuranQuiz')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-5">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-success">Quiz Surat</h3>
                    <p class="text-muted small">Silakan masuk untuk memulai kuis</p>
                </div>

                <!-- Alert Error bawaan Laravel -->
                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary small fw-bold">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary small fw-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                        <label class="form-check-label text-muted small" for="remember_me">Ingat Saya</label>
                    </div>

                    <!-- Button Submit -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm">Masuk</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection