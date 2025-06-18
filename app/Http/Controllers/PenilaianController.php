<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;
use App\Services\MautCalculatorService;
use App\Models\RankingBatch;
use App\Models\RankingDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    protected $mautCalculatorService;

    public function __construct(MautCalculatorService $mautCalculatorService)
    {
        $this->mautCalculatorService = $mautCalculatorService;
        // Middleware untuk otentikasi dan role Tim Penilai
        // $this->middleware(['auth', 'role:tim-penilai'])->except(['showRanking']); // showRanking bisa diakses semua
    }

    /**
     * Menampilkan daftar proyek untuk dinilai atau melihat status penilaian.
     */
    public function index()
    {
        $proyeks = Proyek::all();
        return view('penilaian.index', compact('proyeks'));
    }

    /**
     * Menampilkan formulir untuk input/edit nilai proyek.
     */
    public function createEdit($proyekId)
    {
        $proyek = Proyek::findOrFail($proyekId);
        $kriterias = Kriteria::with('subKriterias')->get(); // Ambil kriteria dan sub-kriterianya
        $nilaiTersimpan = Penilaian::where('proyek_id', $proyekId)
                                ->pluck('sub_kriteria_id', 'kriteria_id')
                                ->toArray(); // Nilai yang sudah tersimpan

        return view('penilaian.create_edit', compact('proyek', 'kriterias', 'nilaiTersimpan'));
    }

    /**
     * Menyimpan atau memperbarui nilai proyek.
     */
    public function storeUpdate(Request $request, $proyekId)
    {
        $proyek = Proyek::findOrFail($proyekId);

        // Validasi input
        $rules = [];
        foreach (Kriteria::all() as $kriteria) {
            // Pastikan ada input untuk setiap kriteria dan itu adalah ID sub-kriteria yang valid
            $rules['kriteria_' . $kriteria->id] = 'required|exists:sub_kriterias,id';
        }
        $validatedData = $request->validate($rules);

        // Simpan atau perbarui nilai penilaian
        foreach ($validatedData as $inputName => $subKriteriaId) {
            $kriteriaId = str_replace('kriteria_', '', $inputName); // Ekstrak kriteria_id

            Penilaian::updateOrCreate(
                ['proyek_id' => $proyek->id, 'kriteria_id' => $kriteriaId],
                ['sub_kriteria_id' => $subKriteriaId]
            );
        }

        return redirect()->route('penilaian.index')->with('success', 'Nilai proyek berhasil disimpan/diperbarui!');
    }

    /**
     * Menampilkan hasil ranking MAUT.
     */
    public function showRanking()
    {
        $rankedProyeks = $this->mautCalculatorService->rankProjects();
        return view('penilaian.ranking', compact('rankedProyeks'));
    }

    // public function saveRanking(Request $request)
    // {
    //     $request->validate([
    //         'nama_sesi' => 'nullable|string|max:255',
    //         'catatan' => 'nullable|string|max:1000',
    //     ]);

    //     $rankedProyeks = $this->mautCalculatorService->rankProjects();

    //     if ($rankedProyeks->isEmpty()) {
    //         return redirect()->back()->with('error', 'Tidak ada proyek yang dapat diranking.');
    //     }

    //     try {
    //         $rankingBatch = RankingBatch::create([
    //             'nama_sesi' => $request->input('nama_sesi') ?? 'Ranking ' . Carbon::now()->format('d M Y H:i'),
    //             'calculated_at' => Carbon::now(),
    //             'catatan' => $request->input('catatan'),
    //         ]);

    //         $rank = 1;
    //         foreach ($rankedProyeks as $proyek) {
    //             RankingDetail::create([
    //                 'ranking_batch_id' => $rankingBatch->id,
    //                 'proyek_id' => $proyek->id,
    //                 'final_maut_score' => $proyek->final_maut_score,
    //                 'rank' => $rank++,
    //             ]);
    //         }
    //         return redirect()->route('awards.history')->with('success', 'Ranking berhasil disimpan!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal menyimpan ranking: ' . $e->getMessage());
    //     }
    // }

    public function saveRanking(Request $request)
    {

        $request->validate([
            'nama_sesi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $rankedProyeks = $this->mautCalculatorService->rankProjects();

        if ($rankedProyeks->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada proyek yang dapat diranking untuk disimpan.');
        }

        try {
            $rankingBatch = RankingBatch::create([
                'nama_sesi' => $request->input('nama_sesi') ?? 'Ranking ' . Carbon::now()->format('d M Y H:i'),
                'calculated_at' => Carbon::now(),
                'catatan' => $request->input('catatan'),
            ]);

            $rank = 1;
            foreach ($rankedProyeks as $proyek) {
                RankingDetail::create([
                    'ranking_batch_id' => $rankingBatch->id,
                    'proyek_id' => $proyek->id,
                    'final_maut_score' => $proyek->maut_score, // <-- PERBAIKAN DI SINI
                    'rank' => $rank++,
                ]);
            }
            return redirect()->route('awards.history')->with('success', 'Ranking berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan ranking: ' . $e->getMessage());
        }
    }

    public function showRankingHistory()
    {
        $rankingBatches = RankingBatch::orderBy('calculated_at', 'desc')->paginate(10);
        return view('penilaian.history', compact('rankingBatches'));
    }

    public function showRankingDetail($batchId)
    {
        $rankingBatch = RankingBatch::with(['details.proyek'])->findOrFail($batchId);
        $rankedDetails = $rankingBatch->details->sortBy('rank'); // Urutkan berdasarkan rank
        return view('penilaian.history_detail', compact('rankingBatch', 'rankedDetails'));
    }
}