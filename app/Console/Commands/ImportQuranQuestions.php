<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportQuranQuestions extends Command
{
    protected $signature = 'quiz:import {count=10}';
    protected $description = 'Import soal kuis acak dari EQuran.id API ke tabel questions';

    public function handle(): int
    {
        $count = (int) $this->argument('count');

        $this->info('Mengambil daftar surah dari EQuran.id...');

        try {
            $listResponse = Http::timeout(15)->get('https://equran.id/api/v2/surat');
        } catch (\Exception $e) {
            $this->error('Gagal menghubungi EQuran.id API: ' . $e->getMessage());
            return self::FAILURE;
        }

        if ($listResponse->failed()) {
            $this->error('Gagal mengambil daftar surah. Status: ' . $listResponse->status());
            return self::FAILURE;
        }

        $surahList = collect($listResponse->json('data'));

        if ($surahList->isEmpty()) {
            $this->error('Daftar surah kosong, periksa response API.');
            return self::FAILURE;
        }

        $created = 0;
        $attempts = 0;
        $maxAttempts = $count * 5;

        while ($created < $count && $attempts < $maxAttempts) {
            $attempts++;

            $surah = $surahList->random();

            try {
                $detail = Http::timeout(15)->get("https://equran.id/api/v2/surat/{$surah['nomor']}");
            } catch (\Exception $e) {
                $this->warn("Gagal mengambil surah {$surah['namaLatin']}, dilewati.");
                continue;
            }

            if ($detail->failed()) {
                continue;
            }

            $ayatList = $detail->json('data.ayat');

            if (empty($ayatList)) {
                continue;
            }

            $ayat = $ayatList[array_rand($ayatList)];

            $exists = Question::where('surah_number', $surah['nomor'])
                ->where('ayat_number', $ayat['nomorAyat'])
                ->exists();

            if ($exists) {
                continue;
            }

            $distractors = $surahList
                ->where('nomor', '!=', $surah['nomor'])
                ->random(3)
                ->pluck('namaLatin')
                ->toArray();

            $options = $distractors;
            $options[] = $surah['namaLatin'];
            shuffle($options);

            $letters = ['a', 'b', 'c', 'd'];
            $optionMap = array_combine($letters, $options);
            $correctLetter = array_search($surah['namaLatin'], $optionMap);

            Question::create([
                'surah_number' => $surah['nomor'],
                'surah_name' => $surah['namaLatin'],
                'ayat_number' => $ayat['nomorAyat'],
                'ayat_text' => $ayat['teksIndonesia'],
                'option_a' => $optionMap['a'],
                'option_b' => $optionMap['b'],
                'option_c' => $optionMap['c'],
                'option_d' => $optionMap['d'],
                'correct_option' => $correctLetter,
            ]);

            $created++;
            $this->info("[{$created}/{$count}] Soal dibuat: QS. {$surah['namaLatin']} ayat {$ayat['nomorAyat']}");
        }

        $this->info("Selesai. Total soal baru: {$created}");
        return self::SUCCESS;
    }
}