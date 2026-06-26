@extends('layouts.app')
@section('title', 'Manajemen User - Admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users-gear me-2"></i> Manajemen Peserta Kuis</h5>
            <span class="badge bg-secondary">Total: {{ $users->total() }} User</span>
        </div>
        <div class="card-body p-4">

            <!-- Alert Notifikasi Sukses / Gagal -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tabel Daftar User -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary small uppercase">
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat Email</th>
                            <th>Tanggal Bergabung</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-secondary font-monospace">{{ $users->firstItem() + $index }}</td>
                                <td class="fw-bold text-dark">{{ $user->name }}</td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td class="text-muted small">{{ $user->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="text-center">
                                    <!-- Form Hapus User -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}? Semua riwayat nilai kuisnya juga akan terhapus secara permanen!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold">
                                            <i class="fa-solid fa-trash-can me-1"></i> Haps
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada user atau peserta kuis lain yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="d-flex justify-content-end mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>
@endsection