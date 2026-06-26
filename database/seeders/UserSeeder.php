<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun user default untuk kuis
        User::updateOrCreate(
            ['email' => 'peserta@user.com'], // Mencegah duplikat jika seeder dijalankan ulang
            [
                'name'     => 'Peserta Kuis',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}