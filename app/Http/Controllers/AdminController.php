<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan semua user yang terdaftar (Kecuali Admin sendiri)
     */
    public function index()
    {
        // Mengambil semua user selain yang sedang login saat ini
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', [
        'users' => $users
        ]);
    }

    /**
     * Hapus user beserta riwayat kuisnya secara permanen
     */
    public function destroy(User $user)
    {
        // Proteksi tambahan agar tidak bisa menghapus diri sendiri lewat URL
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User dan semua riwayat kuisnya berhasil dihapus secara permanen.');
    }

    /**
     * Menampilkan halaman rekap nilai seluruh peserta untuk Admin
     */
    public function rekapNilai()
    {
        // Proteksi jika user biasa mencoba menembak URL rekap ini
        if (auth()->user()->email === 'peserta@user.com') {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini!');
        }

        // Ambil data rekap nilai terbaru, di-paginate 15 data per halaman
        $results = QuizResult::with('user')
            ->orderBy('played_at', 'desc')
            ->paginate(15);

        return view('admin.rekap-nilai', compact('results'));
    }
}