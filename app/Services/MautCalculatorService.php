<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Proyek;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Support\Collection;

class MautCalculatorService
{
    // ==================================================================================
    // METODE PERHITUNGAN 1: SKALA ABSOLUT (PERILAKU AWAL SISTEM)
    // ==================================================================================

    /**
     * [ABSOLUT] Menghitung skor MAUT untuk SATU proyek.
     * MIN/MAX diambil dari semua kemungkinan nilai sub-kriteria di database.
     *
     * @param Proyek $proyek
     * @return float
     */
    public function calculateMautScoreAbsolute(Proyek $proyek): float
    {
        $totalMautScore = 0.0;
        $kriterias = Kriteria::all();
        if ($kriterias->sum('bobot') == 0) return 0.0;

        foreach ($kriterias as $kriteria) {
            $penilaian = Penilaian::where('proyek_id', $proyek->id)
                ->where('kriteria_id', $kriteria->id)
                ->with('subKriteria')->first();

            if ($penilaian && $penilaian->subKriteria) {
                $rawValue = $penilaian->subKriteria->nilai_sub_kriteria;
                // MIN/MAX diambil dari semua sub-kriteria yang ada untuk kriteria ini.
                $min = SubKriteria::where('kriteria_id', $kriteria->id)->min('nilai_sub_kriteria');
                $max = SubKriteria::where('kriteria_id', $kriteria->id)->max('nilai_sub_kriteria');
                if ($max == $min) {
                    $utilityValue = 1.0;
                } else {
                    $utilityValue = ($rawValue - $min) / ($max - $min);
                }
                if ($kriteria->tipe_kriteria === 'cost') {
                    $utilityValue = 1 - $utilityValue;
                }
                $totalMautScore += ($kriteria->bobot * $utilityValue);
            }
        }
        return $totalMautScore;
    }

    /**
     * [ABSOLUT] Meranking semua proyek yang dinilai menggunakan metode Skala Absolut.
     *
     * @return Collection
     */
    public function rankProjectsAbsolute(): Collection
    {
        $proyeks = Proyek::whereHas('penilaians')->get();
        $rankedProyeks = new Collection();
        foreach ($proyeks as $proyek) {
            $proyek->maut_score = $this->calculateMautScoreAbsolute($proyek);
            $rankedProyeks->push($proyek);
        }
        return $rankedProyeks->sortByDesc('maut_score');
    }

    /**
     * [ABSOLUT] Mendapatkan detail perhitungan untuk debugging (Metode Absolut).
     *
     * @param Proyek $proyek
     * @return array
     */
    public function getCalculationDetailsAbsolute(Proyek $proyek): array
    {
        $details = ['proyek_id' => $proyek->id, 'proyek_nama' => $proyek->nama_proyek, 'criteria_details' => []];
        $kriterias = Kriteria::all();
        foreach ($kriterias as $kriteria) {
            $penilaian = Penilaian::where('proyek_id', $proyek->id)->where('kriteria_id', $kriteria->id)->with('subKriteria')->first();
            $criteriaDetail = ['kriteria_id' => $kriteria->id, 'nama_kriteria' => $kriteria->nama_kriteria, 'tipe_kriteria' => $kriteria->tipe_kriteria, 'original_weight' => $kriteria->bobot, 'has_penilaian' => false];
            if ($penilaian && $penilaian->subKriteria) {
                $rawValue = $penilaian->subKriteria->nilai_sub_kriteria;
                $min = SubKriteria::where('kriteria_id', $kriteria->id)->min('nilai_sub_kriteria');
                $max = SubKriteria::where('kriteria_id', $kriteria->id)->max('nilai_sub_kriteria');
                $utilityValue = ($max == $min) ? 1.0 : ($rawValue - $min) / ($max - $min);
                $adjustedUtilityValue = ($kriteria->tipe_kriteria === 'cost') ? (1 - $utilityValue) : $utilityValue;
                $criteriaDetail = array_merge($criteriaDetail, [
                    'has_penilaian' => true, 'raw_utility_value' => $rawValue, 'min_value' => $min, 'max_value' => $max,
                    'normalized_utility_value' => $utilityValue, 'adjusted_utility_value' => $adjustedUtilityValue,
                    'bobot_x_normalized' => $kriteria->bobot * $utilityValue
                ]);
            }
            $details['criteria_details'][] = $criteriaDetail;
        }
        $details['final_maut_score'] = $this->calculateMautScoreAbsolute($proyek);
        return $details;
    }

    // ==================================================================================
    // METODE PERHITUNGAN 2: SKALA RELATIF (SESUAI PERHITUNGAN EXCEL)
    // ==================================================================================

    /**
     * [RELATIF] Meranking proyek dan menghasilkan detail debug menggunakan metode Skala Relatif.
     * MIN/MAX diambil dari nilai-nilai yang ada di antara proyek yang sedang dinilai saja.
     *
     * @return array [Collection $rankedProyeks, array $debugDetails]
     */
    public function rankAndDebugRelative(): array
    {
        $proyeks = Proyek::whereHas('penilaians')->with('penilaians.subKriteria.kriteria')->get();
        if ($proyeks->isEmpty()) {
            return [new Collection(), []];
        }

        $kriterias = Kriteria::all();
        $kriteriaBounds = new Collection();

        // Tahap 1: Tentukan MIN dan MAX untuk setiap kriteria berdasarkan HANYA nilai yang ada saat ini.
        foreach ($kriterias as $kriteria) {
            $penilaianForKriteria = Penilaian::where('penilaians.kriteria_id', $kriteria->id)
                ->whereIn('proyek_id', $proyeks->pluck('id'))
                ->join('sub_kriterias', 'penilaians.sub_kriteria_id', '=', 'sub_kriterias.id')
                ->pluck('nilai_sub_kriteria');

            if ($penilaianForKriteria->isNotEmpty()) {
                $kriteriaBounds[$kriteria->id] = ['min' => $penilaianForKriteria->min(), 'max' => $penilaianForKriteria->max()];
            }
        }

        $rankedProyeks = new Collection();
        $debugDetails = [];

        // Tahap 2: Hitung skor setiap proyek menggunakan MIN/MAX relatif yang sudah ditemukan.
        foreach ($proyeks as $proyek) {
            $totalMautScore = 0.0;
            $proyekDebug = ['proyek_id' => $proyek->id, 'proyek_nama' => $proyek->nama_proyek, 'criteria_details' => []];

            foreach ($kriterias as $kriteria) {
                $penilaian = $proyek->penilaians->where('kriteria_id', $kriteria->id)->first();
                $bounds = $kriteriaBounds->get($kriteria->id);
                $criteriaDetail = ['kriteria_id' => $kriteria->id, 'nama_kriteria' => $kriteria->nama_kriteria, 'tipe_kriteria' => $kriteria->tipe_kriteria, 'original_weight' => $kriteria->bobot, 'has_penilaian' => false];

                if ($penilaian && $penilaian->subKriteria && $bounds) {
                    $rawValue = $penilaian->subKriteria->nilai_sub_kriteria;
                    $min = $bounds['min'];
                    $max = $bounds['max'];
                    $utilityValue = ($max == $min) ? 1.0 : ($rawValue - $min) / ($max - $min);
                    $adjustedUtilityValue = ($kriteria->tipe_kriteria === 'cost') ? (1 - $utilityValue) : $utilityValue;
                    $totalMautScore += ($kriteria->bobot * $adjustedUtilityValue); // Gunakan adjusted untuk cost
                    
                    $criteriaDetail = array_merge($criteriaDetail, [
                        'has_penilaian' => true, 'raw_utility_value' => $rawValue, 'min_value' => $min, 'max_value' => $max,
                        'normalized_utility_value' => $utilityValue, 'adjusted_utility_value' => $adjustedUtilityValue,
                        'bobot_x_normalized' => $kriteria->bobot * $utilityValue
                    ]);
                }
                $proyekDebug['criteria_details'][] = $criteriaDetail;
            }

            $proyek->maut_score = $totalMautScore;
            $proyekDebug['final_maut_score'] = $totalMautScore;
            $rankedProyeks->push($proyek);
            $debugDetails[$proyek->id] = $proyekDebug;
        }

        return [$rankedProyeks, $debugDetails];
    }
}