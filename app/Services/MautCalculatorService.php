<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Proyek;
use App\Models\Penilaian; // Import model Penilaian yang baru dibuat
use Illuminate\Support\Collection;

class MautCalculatorService
{
    /**
     * Menghitung skor MAUT untuk satu proyek berdasarkan penilai.
     * Ini akan mengambil nilai utilitas dari sub-kriteria yang telah dipilih dan bobot kriteria utama.
     *
     * @param Proyek $proyek
     * @return float
     */
    public function calculateMautScore(Proyek $proyek): float
    {
        $totalMautScore = 0.0;

        // Ambil semua kriteria beserta bobotnya
        $kriterias = Kriteria::all();

        foreach ($kriterias as $kriteria) {
            // Cari penilaian yang sesuai untuk proyek ini dan kriteria ini
            $penilaian = Penilaian::where('proyek_id', $proyek->id)
                                ->where('kriteria_id', $kriteria->id)
                                ->with('subKriteria') // Muat relasi subKriteria
                                ->first();

            if ($penilaian && $penilaian->subKriteria) {
                // nilai_sub_kriteria dari tabel sub_kriteria adalah utility value
                $utilityValue = $penilaian->subKriteria->nilai_sub_kriteria;
                $bobotKriteria = $kriteria->bobot; // Bobot utama dari tabel kriteria

                $totalMautScore += ($bobotKriteria * $utilityValue);
            }
        }

        return $totalMautScore;
    }

    /**
     * Menghitung skor MAUT untuk semua proyek yang sudah dinilai dan merankingnya.
     *
     * @return Collection
     */
    public function rankProjects(): Collection
    {
        $proyeks = Proyek::all();
        $rankedProyeks = new Collection();

        foreach ($proyeks as $proyek) {
            // Pastikan proyek sudah memiliki penilaian sebelum dihitung
            if (Penilaian::where('proyek_id', $proyek->id)->exists()) {
                $mautScore = $this->calculateMautScore($proyek);
                $proyek->maut_score = $mautScore; // Tambahkan skor MAUT ke objek proyek
                $rankedProyeks->push($proyek);
            }
        }

        $maxScore = $rankedProyeks->max('maut_score');

        if ($maxScore > 0) {
            foreach ($rankedProyeks as $proyek) {
                $proyek->normalized_score = $proyek->maut_score / $maxScore;
            }
        } else {
            foreach ($rankedProyeks as $proyek) {
                $proyek->normalized_score = 0;
            }
        }

        // Urutkan berdasarkan skor MAUT secara menurun (tertinggi di atas)
        return $rankedProyeks->sortByDesc('normalized_score');
    }
}