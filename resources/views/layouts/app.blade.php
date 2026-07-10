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

    <!-- CHATBOT HANYA DIAKSES JIKA USER SUDAH LOGIN -->
    @auth
    <!-- Chatbot Widget -->
    <div id="chatbot-container" style="position:fixed; bottom:20px; right:20px; z-index:9999;">

        <!-- Tombol buka chatbot -->
        <button id="chatbot-toggle" onclick="toggleChatbot()"
            class="btn btn-success rounded-circle shadow"
            style="width:60px; height:60px; font-size:24px;">
            <i class="fa-solid fa-comment-dots"></i>
        </button>

        <!-- Kotak chat -->
        <div id="chatbot-box"
            style="display:none; width:350px; height:450px; background:white; border-radius:12px;
                   box-shadow:0 4px 20px rgba(0,0,0,0.2); margin-bottom:10px; flex-direction:column; overflow:hidden;">

            <!-- Header -->
            <div class="bg-success text-white p-3 d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-robot"></i>
                    <strong> Asisten Al-Qur'an</strong>
                </div>
                <button onclick="toggleChatbot()" class="btn btn-sm btn-outline-light">✕</button>
            </div>

            <!-- Area chat -->
            <div id="chat-messages"
                style="flex:1; overflow-y:auto; padding:15px; height:300px; background:#f8f9fa;">
                <div class="text-center text-muted small mb-3">
                    Tanyakan apa saja seputar Al-Qur'an & Tafsir
                </div>
                <div class="d-flex mb-2">
                    <div class="bg-success text-white rounded p-2 small" style="max-width:80%;">
                        Assalamu'alaikum! Saya siap membantu menjawab pertanyaan seputar Al-Qur'an dan tafsir. Silakan tanya! 😊
                    </div>
                </div>
            </div>

            <!-- Input area -->
            <div class="p-3 border-top bg-white">
                <div class="input-group">
                    <input type="text" id="chat-input"
                        class="form-control form-control-sm"
                        placeholder="Ketik pertanyaan..."
                        onkeypress="handleEnter(event)">
                    <button class="btn btn-success btn-sm" onclick="sendMessage()">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleChatbot() {
            const box = document.getElementById('chatbot-box');
            if (box.style.display === 'none') {
                box.style.display = 'flex';
                box.style.flexDirection = 'column';
            } else {
                box.style.display = 'none';
            }
        }

        function handleEnter(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function removeLoading() {
            const loadingMsg = document.getElementById('loading-msg');
            if (loadingMsg) {
                loadingMsg.remove();
            }
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();

            if (!message) return;

            const messagesDiv = document.getElementById('chat-messages');

            // Tampilkan pesan user
            messagesDiv.innerHTML += `
                <div class="d-flex justify-content-end mb-2">
                    <div class="bg-primary text-white rounded p-2 small" style="max-width:80%;">
                        ${message}
                    </div>
                </div>`;

            removeLoading();

            // Tampilkan loading spinner
            messagesDiv.innerHTML += `
                <div class="d-flex mb-2" id="loading-msg">
                    <div class="bg-light border rounded p-2 small text-muted">
                        <i class="fa-solid fa-spinner fa-spin"></i> Sedang menjawab...
                    </div>
                </div>`;

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
            input.value = '';

            // Jalankan request ke endpoint Laravel
            fetch('{{ route("chatbot.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                removeLoading();

                // Membaca key 'error' atau 'reply' dari ChatbotController secara konsisten
                if (data.error) {
                    messagesDiv.innerHTML += `
                        <div class="d-flex mb-2">
                            <div class="bg-danger text-white rounded p-2 small" style="max-width:80%;">
                                ❌ ${data.error}
                            </div>
                        </div>`;
                } else if (data.reply) {
                    const formattedAnswer = data.reply.replace(/\n/g, '<br>');
                    messagesDiv.innerHTML += `
                        <div class="d-flex mb-2">
                            <div class="bg-success text-white rounded p-2 small" style="max-width:80%;">
                                ${formattedAnswer}
                            </div>
                        </div>`;
                } else {
                    messagesDiv.innerHTML += `
                        <div class="d-flex mb-2">
                            <div class="bg-danger text-white rounded p-2 small" style="max-width:80%;">
                                ❌ Terjadi kesalahan format data dari server.
                            </div>
                        </div>`;
                }

                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            })
            .catch(err => {
                removeLoading();
                
                messagesDiv.innerHTML += `
                    <div class="d-flex mb-2">
                        <div class="bg-danger text-white rounded p-2 small" style="max-width:80%;">
                            ❌ Gagal menghubungi server. Jalur koneksi terputus.
                        </div>
                    </div>`;
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            });
        }
    </script>
    @endauth
</body>
</html>