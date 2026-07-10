@extends('layouts.app')
@section('title', 'Rekap Nilai Peserta - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success mb-1">📋 Laporan Hasil Kuis</h3>
            <p class="text-muted small mb-0">Halaman khusus admin untuk memantau nilai dan durasi pengerjaan kuis peserta.</p>
        </div>
        <div>
            <button class="btn btn-sm btn-danger shadow-sm"><i class="fa-solid fa-file-pdf me-1"></i> Cetak PDF</button>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-success text-dark">
                        <tr>
                            <th class="ps-4 py-3" style="width: 60px;">No</th>
                            <th py-3>Nama Peserta</th>
                            <th py-3>Email</th>
                            <th class="text-center" py-3>Jawaban Benar</th>
                            <th class="text-center" py-3>Skor Akhir</th>
                            <th class="text-center" py-3>Durasi</th>
                            <th class="pe-4 py-3 text-end" style="width: 200px;">Tanggal Main</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $index => $res)
                            <tr>
                                <td class="ps-4 fw-medium text-muted">
                                    {{ $results->firstItem() + $index }}
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $res->user->name ?? 'User Terhapus' }}</span>
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $res->user->email ?? '-' }}</span>
                                </td>
                                <td class="text-center fw-semibold">
                                    <span class="badge bg-light text-success border border-success-subtle px-2 py-1">
                                        🎯 {{ $res->correct_answers }} / {{ $res->total_questions }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fs-5 fw-bold {{ $res->score >= 70 ? 'text-success' : 'text-warning' }}">
                                        {{ $res->score }}
                                    </span>
                                </td>
                                <td class="text-center text-muted small">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    @if($res->duration_seconds < 60)
                                        {{ $res->duration_seconds }}d
                                    @else
                                        {{ floor($res->duration_seconds / 60) }}m {{ $res->duration_seconds % 60 }}d
                                    @endif
                                </td>
                                <td class="pe-4 text-end text-muted small">
                                    {{ $res->played_at ? \Carbon\Carbon::parse($res->played_at)->translatedFormat('d M Y, H:i') : $res->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fa-3x mb-3 d-block opacity-50"></i>
                                    Belum ada data riwayat kuis yang dimainkan oleh peserta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $results->links() }}
    </div>
</div>
@endsection