<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;
use App\Models\User;
use App\Services\MautCalculatorService;
use App\Models\RankingBatch;
use App\Models\RankingDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $kriterias = Kriteria::with('subKriterias')->get();
        $nilaiTersimpan = Penilaian::where('proyek_id', $proyekId)
                                ->pluck('sub_kriteria_id', 'kriteria_id')
                                ->toArray();
        // Navigasi proyek sebelumnya/berikutnya
        $allProyeks = Proyek::orderBy('id')->pluck('id')->toArray();
        $currentIndex = array_search($proyek->id, $allProyeks);
        $prevProyekId = $currentIndex > 0 ? $allProyeks[$currentIndex - 1] : null;
        $nextProyekId = $currentIndex < count($allProyeks) - 1 ? $allProyeks[$currentIndex + 1] : null;
        return view('penilaian.create_edit', compact('proyek', 'kriterias', 'nilaiTersimpan', 'prevProyekId', 'nextProyekId'));
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

        // Navigasi ke proyek berikutnya jika ada
        $allProyeks = Proyek::orderBy('id')->pluck('id')->toArray();
        $currentIndex = array_search($proyek->id, $allProyeks);
        $nextProyekId = $currentIndex < count($allProyeks) - 1 ? $allProyeks[$currentIndex + 1] : null;
        if ($nextProyekId) {
            return redirect()->route('penilaian.create_edit', $nextProyekId)->with('success', 'Nilai proyek berhasil disimpan! Silakan lanjut ke proyek berikutnya.');
        }
        return redirect()->route('penilaian.index')->with('success', 'Nilai proyek berhasil disimpan!');
    }

    /**
     * Menampilkan hasil ranking MAUT.
     */
    public function showRanking()
    {
        // --- PILIH METODE PERHITUNGAN ---
        // Ganti nilai variabel $method di bawah ini untuk mengubah cara kalkulasi.
        // Pilihan yang tersedia:
        // 'relative' => Sesuai perhitungan Excel (MIN/MAX dari data yang ada).
        // 'absolute' => Sesuai perilaku awal sistem (MIN/MAX dari semua kemungkinan sub-kriteria).
        
        $method = 'relative'; // <-- Ganti di sini jika perlu

        if ($method === 'relative') {
            // Metode Skala Relatif (Sesuai Excel)
            list($rankedProyeks, $debugDetails) = $this->mautCalculatorService->rankAndDebugRelative();
        } else {
            // Metode Skala Absolut (Perilaku Awal Sistem)
            $rankedProyeks = $this->mautCalculatorService->rankProjectsAbsolute();
            $debugDetails = [];
            foreach ($rankedProyeks as $proyek) {
                $debugDetails[$proyek->id] = $this->mautCalculatorService->getCalculationDetailsAbsolute($proyek);
            }
        }
        
        return view('penilaian.ranking', compact('rankedProyeks', 'debugDetails', 'method'));
    }

    public function saveRanking(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'calculation_method' => 'required|in:relative,absolute',
            'calculated_at' => 'required|date',
        ]);

        $method = $request->input('calculation_method');
        
        if ($method === 'relative') {
            list($rankedProyeks, $debugDetails) = $this->mautCalculatorService->rankAndDebugRelative();
        } else { // 'absolute'
            $rankedProyeks = $this->mautCalculatorService->rankProjectsAbsolute();
            $debugDetails = [];
            foreach ($rankedProyeks as $proyek) {
                $debugDetails[$proyek->id] = $this->mautCalculatorService->getCalculationDetailsAbsolute($proyek);
            }
        }

        if ($rankedProyeks->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada proyek yang dapat diranking untuk disimpan.');
        }

        try {
            // Ambil semua data penilaian sebelum dihapus
            $allPenilaian = \App\Models\Penilaian::with(['proyek', 'kriteria', 'subKriteria'])->get();
            $assessmentDetails = $allPenilaian->map(function($p) {
                return [
                    'proyek_id' => $p->proyek_id,
                    'proyek_nama' => $p->proyek->nama_proyek ?? null,
                    'kriteria_id' => $p->kriteria_id,
                    'kriteria_nama' => $p->kriteria->nama_kriteria ?? null,
                    'kode_kriteria' => $p->kriteria->kode_kriteria ?? null,
                    'sub_kriteria_id' => $p->sub_kriteria_id,
                    'sub_kriteria_nama' => $p->subKriteria->nama_sub_kriteria ?? null,
                    'nilai_sub_kriteria' => $p->subKriteria->nilai_sub_kriteria ?? null,
                ];
            });

            $rankingBatch = RankingBatch::create([
                'nama_sesi' => $request->input('nama_sesi') ?? 'Ranking ' . Carbon::now()->format('d M Y H:i'),
                'calculated_at' => $request->input('calculated_at'),
                'catatan' => $request->input('catatan'),
                'user_id' => Auth::id(),
                'calculation_details' => json_encode($debugDetails),
                'assessment_details' => $assessmentDetails->toJson(),
            ]);

            $rank = 1;
            foreach ($rankedProyeks as $proyek) {
                RankingDetail::create([
                    'ranking_batch_id' => $rankingBatch->id,
                    'proyek_id' => $proyek->id,
                    'final_maut_score' => $proyek->maut_score,
                    'rank' => $rank++, 
                ]);
            }
            // Hapus semua data penilaian setelah ranking disimpan
            \App\Models\Penilaian::truncate();
            return redirect()->route('awards.history')->with('success', 'Ranking berhasil disimpan dan semua nilai proyek telah direset!');
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
        $rankingBatch = RankingBatch::with(['details.proyek', 'user'])->findOrFail($batchId);
        // Debug: cek isi calculation_details
        // dd($rankingBatch->calculation_details);
        $rankedDetails = $rankingBatch->details->sortBy('rank'); // Urutkan berdasarkan rank
        return view('penilaian.history_detail', compact('rankingBatch', 'rankedDetails'));
    }

    public function editRankingBatch($batchId)
    {
        $rankingBatch = \App\Models\RankingBatch::findOrFail($batchId);
        $users = User::all();
        return view('penilaian.edit_ranking_batch', compact('rankingBatch', 'users'));
    }

    public function updateRankingBatch(Request $request, $batchId)
    {
        $rankingBatch = \App\Models\RankingBatch::findOrFail($batchId);
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'calculated_at' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);
        $rankingBatch->update([
            'nama_sesi' => $request->input('nama_sesi'),
            'catatan' => $request->input('catatan'),
            'calculated_at' => $request->input('calculated_at'),
            'user_id' => $request->input('user_id'),
        ]);
        return redirect()->route('awards.history')->with('success', 'Riwayat ranking berhasil diperbarui.');
    }

    public function destroyRankingBatch($batchId)
    {
        $rankingBatch = \App\Models\RankingBatch::findOrFail($batchId);
        $rankingBatch->delete(); // Akan otomatis menghapus detail karena relasi cascade
        return redirect()->route('awards.history')->with('success', 'Riwayat ranking berhasil dihapus.');
    }

    public function destroy($proyekId)
    {
        Penilaian::where('proyek_id', $proyekId)->delete();
        return redirect()->route('penilaian.index')->with('success', 'Nilai untuk proyek berhasil dihapus.');
    }

    public function exportHistoryDetailPdf($batchId)
    {
        $rankingBatch = RankingBatch::with(['details.proyek', 'user'])->findOrFail($batchId);
        $rankedDetails = $rankingBatch->details->sortBy('rank');
        $debugDetails = $rankingBatch->calculation_details ? json_decode($rankingBatch->calculation_details, true) : null;
        $firstDetail = $debugDetails ? reset($debugDetails) : null;
        $pdf = Pdf::loadView('penilaian.history_detail_pdf', compact('rankingBatch', 'rankedDetails', 'debugDetails', 'firstDetail'));
        $filename = 'Riwayat_Ranking_'.$rankingBatch->id.'.pdf';
        return $pdf->stream($filename);
    }

    public function exportHistoryPdf()
    {
        $rankingBatches = RankingBatch::with(['details.proyek', 'user'])->latest()->get();
        return Pdf::loadView('penilaian.history_pdf', compact('rankingBatches'))
            ->setPaper('a4', 'landscape')
            ->stream('riwayat-ranking-hse-awards.pdf');
    }
}