<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Proyek;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Support\Collection;

class MautCalculatorService
{
    /**
     * Menghitung skor MAUT untuk satu proyek berdasarkan penilai.
     * Utility value diambil dari sub_kriteria lalu dinormalisasi min-max per kriteria.
     * Bobot dinormalisasi.
     * Kriteria cost dibalik utility value-nya.
     *
     * @param Proyek $proyek
     * @return float
     */
    public function calculateMautScore(Proyek $proyek): float
    {
        $totalMautScore = 0.0;
        $kriterias = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');
        if ($totalBobot == 0) return 0.0;

        foreach ($kriterias as $kriteria) {
            $penilaian = Penilaian::where('proyek_id', $proyek->id)
                ->where('kriteria_id', $kriteria->id)
                ->with('subKriteria')
                ->first();

            if ($penilaian && $penilaian->subKriteria) {
                $rawValue = $penilaian->subKriteria->nilai_sub_kriteria;
                // Normalisasi min-max per kriteria
                $min = SubKriteria::where('kriteria_id', $kriteria->id)->min('nilai_sub_kriteria');
                $max = SubKriteria::where('kriteria_id', $kriteria->id)->max('nilai_sub_kriteria');
                if ($max == $min) {
                    $utilityValue = 1.0;
                } else {
                    $utilityValue = ($rawValue - $min) / ($max - $min);
                }
                $normalizedBobot = $kriteria->bobot / $totalBobot;
                if ($kriteria->tipe_kriteria === 'cost') {
                    $utilityValue = 1 - $utilityValue;
                }
                $totalMautScore += ($normalizedBobot * $utilityValue);
            }
        }
        return $totalMautScore;
    }

    /**
     * Menghitung skor MAUT untuk semua proyek yang sudah dinilai dan merankingnya.
     * Tidak perlu normalisasi skor akhir, cukup urutkan berdasarkan skor MAUT.
     *
     * @return Collection
     */
    public function rankProjects(): Collection
    {
        $proyeks = Proyek::all();
        $rankedProyeks = new Collection();

        foreach ($proyeks as $proyek) {
            if (Penilaian::where('proyek_id', $proyek->id)->exists()) {
                $mautScore = $this->calculateMautScore($proyek);
                $proyek->maut_score = $mautScore;
                $rankedProyeks->push($proyek);
            }
        }

        // Urutkan berdasarkan skor MAUT secara menurun (tertinggi di atas)
        return $rankedProyeks->sortByDesc('maut_score');
    }

    /**
     * Validasi bobot kriteria
     * Memastikan total bobot = 1.0
     *
     * @return bool
     */
    public function validateWeights(): bool
    {
        $totalBobot = Kriteria::sum('bobot');
        return abs($totalBobot - 1.0) < 0.001; // Toleransi 0.001
    }

    /**
     * Mendapatkan total bobot kriteria
     *
     * @return float
     */
    public function getTotalWeight(): float
    {
        return Kriteria::sum('bobot');
    }

    /**
     * Mendapatkan detail perhitungan untuk debugging
     * 
     * @param Proyek $proyek
     * @return array
     */
    public function getCalculationDetails(Proyek $proyek): array
    {
        $details = [
            'proyek_id' => $proyek->id,
            'proyek_nama' => $proyek->nama_proyek,
            'total_weight' => $this->getTotalWeight(),
            'weight_valid' => $this->validateWeights(),
            'criteria_details' => []
        ];

        $kriterias = Kriteria::all();

        foreach ($kriterias as $kriteria) {
            $penilaian = Penilaian::where('proyek_id', $proyek->id)
                                ->where('kriteria_id', $kriteria->id)
                                ->with('subKriteria')
                                ->first();

            $criteriaDetail = [
                'kriteria_id' => $kriteria->id,
                'nama_kriteria' => $kriteria->nama_kriteria,
                'tipe_kriteria' => $kriteria->tipe_kriteria,
                'original_weight' => $kriteria->bobot,
                'has_penilaian' => false
            ];

            if ($penilaian && $penilaian->subKriteria) {
                $utilityValue = $penilaian->subKriteria->nilai_sub_kriteria;
                $adjustedUtilityValue = $utilityValue;
                if ($kriteria->tipe_kriteria === 'cost') {
                    $adjustedUtilityValue = 1 - $utilityValue;
                }

                $criteriaDetail['has_penilaian'] = true;
                $criteriaDetail['sub_kriteria_id'] = $penilaian->subKriteria->id;
                $criteriaDetail['nama_sub_kriteria'] = $penilaian->subKriteria->nama_sub_kriteria;
                $criteriaDetail['raw_utility_value'] = $utilityValue;
                $criteriaDetail['adjusted_utility_value'] = $adjustedUtilityValue;
            }

            $details['criteria_details'][] = $criteriaDetail;
        }

        $details['final_maut_score'] = $this->calculateMautScore($proyek);

        return $details;
    }
}