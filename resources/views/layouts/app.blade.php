<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QuranQuiz')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f4f6f8; }
        .navbar-brand { font-weight: bold; }
    </style>
</head> 
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🕋 QuranQuiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- JIKA USER SUDAH LOGIN -->
                    @auth
                        <!-- Menu utama untuk semua user yang login -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fa-solid fa-gauge me-1"></i> Dashboard
                            </a>
                        </li>

                        <!-- Menu khusus Admin (Hanya muncul jika BUKAN peserta@user.com) -->
                        @if(auth()->user()->email !== 'peserta@user.com')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fa-solid fa-user-shield me-1"></i> Data User
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.rekap.nilai') ? 'active fw-bold text-warning' : '' }}" href="{{ route('admin.rekap.nilai') }}">
                                <i class="fa-solid fa-chart-simple me-1"></i> Rekap Nilai
                                </a>
                            </li>
                        @endif

                        <!-- Dropdown Nama User -->
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle bg-white bg-opacity-25 rounded px-3 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger small fw-bold">🚪 Keluar (Logout)</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <!-- JIKA USER BELUM LOGIN -->
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light btn-sm fw-bold text-success px-3" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Global Alert Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>