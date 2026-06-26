@extends('layouts.app')
@section('title', 'Daftar Akun - QuranQuiz')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-5">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-success">Daftar Akun</h3>
                    <p class="text-muted small">Buat akun kuis baru Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label text-secondary small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary small fw-bold">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary small fw-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label text-secondary small fw-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm">Daftar</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection