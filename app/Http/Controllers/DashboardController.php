<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyek;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\RankingBatch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalProyek = Proyek::count();
        $totalKriteria = Kriteria::count();
        $totalSubKriteria = SubKriteria::count();
        $totalRanking = RankingBatch::count();

        $recentProyek = Proyek::latest()->take(5)->get();
        $recentRankingBatches = RankingBatch::with(['user', 'details.proyek'])
            ->latest('calculated_at')
            ->take(5)
            ->get()
            ->map(function($batch) {
                return [
                    'id' => $batch->id,
                    'nama_sesi' => $batch->nama_sesi,
                    'calculated_at' => $batch->calculated_at ? $batch->calculated_at->format('d M Y H:i') : null,
                    'user_name' => $batch->user ? $batch->user->name : null,
                    'details' => $batch->details->map(function($detail) {
                        return [
                            'final_maut_score' => $detail->final_maut_score,
                            'proyek' => $detail->proyek ? $detail->proyek->nama_proyek : null,
                        ];
                    })->toArray(),
                ];
            })->toArray();

        return view('dashboard', compact('totalProyek', 'totalKriteria', 'totalSubKriteria', 'totalRanking', 'recentProyek', 'recentRankingBatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
