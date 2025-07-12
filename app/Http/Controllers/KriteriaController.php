<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Sub_kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periode = Periode::getActivePeriode();
        $kriterias = $periode ? Kriteria::where('periode_id', $periode->id)->get() : collect();
        $tahunList = Kriteria::where('periode_id', $periode?->id)->select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun')->toArray();
        $tahunTerbaru = $tahunList[0] ?? date('Y');
        $tahunDipilih = $request->get('tahun', $tahunTerbaru);
        $kriterias = $kriterias->where('tahun', $tahunDipilih);
        $total_bobot = $kriterias->sum('bobot');
        return view('kriterias.index', compact('kriterias', 'total_bobot', 'tahunList', 'tahunDipilih'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari kode kriteria terakhir
        $lastKode = Kriteria::orderByDesc('id')->value('kode_kriteria');
        $nextKode = 'K1';
        if ($lastKode && preg_match('/K(\d+)/', $lastKode, $m)) {
            $nextKode = 'K' . ((int)$m[1] + 1);
        } elseif (Kriteria::count() > 0) {
            $nextKode = 'K' . (Kriteria::count() + 1);
        }
        return view('kriterias.create', ['nextKodeKriteria' => $nextKode]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:255',
            'nama_kriteria' => 'required|string|max:255',
            'keterangan_kriteria' => 'string|max:255',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);
        $periode = Periode::getActivePeriode();
        Kriteria::create(array_merge(
            $request->only(['kode_kriteria', 'nama_kriteria', 'keterangan_kriteria', 'tipe_kriteria', 'bobot', 'tahun']),
            ['periode_id' => $periode?->id]
        ));
        return redirect()->route('kriterias.index')->with('success', 'Kriteria created successfully.');
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
    public function edit(Kriteria $kriteria)
    {
        // Return the edit view with the Kriteria data
        return view('kriterias.edit', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $canEdit = Auth::user()->can('kriteria.edit');
        $canInputBobot = Auth::user()->can('kriteria.input_bobot');
        if (!$canEdit && !$canInputBobot) {
            abort(403, 'Unauthorized action.');
        }
        if (!$canEdit && $canInputBobot) {
            $request->validate([
                'bobot' => 'required|numeric',
            ]);
            $newBobot = $request->bobot;
            $total_bobot = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');
            if (($total_bobot + $newBobot) > 1) {
                return redirect()->back()->withInput()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 1.']);
            }
            
            // Track perubahan bobot
            if ($kriteria->bobot != $newBobot) {
                \App\Models\KriteriaHistory::create([
                    'kriteria_id' => $kriteria->id,
                    'user_id' => auth()->id(),
                    'field' => 'bobot',
                    'old_value' => $kriteria->bobot,
                    'new_value' => $newBobot,
                    'changed_at' => now(),
                ]);
            }
            
            $kriteria->update(['bobot' => $newBobot]);
            return redirect()->route('kriterias.index')->with('success', 'Bobot kriteria berhasil diperbarui.');
        }
        $request->validate([
            'kode_kriteria' => 'nullable|string|max:255',
            'nama_kriteria' => 'required|string|max:255',
            'keterangan_kriteria' => 'string|max:255',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);
        $total_bobot = Kriteria::where('id', '!=', $kriteria->id)
            ->where('periode_id', $kriteria->periode_id)
            ->where('tahun', $kriteria->tahun)
            ->sum('bobot');
        if (($total_bobot + $request->bobot) > 1) {
            return redirect()->back()->withInput()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 1.']);
        }
        $periode = Periode::getActivePeriode();
        // Cek perubahan semua field dan simpan ke history
        $fieldsToTrack = ['kode_kriteria', 'nama_kriteria', 'keterangan_kriteria', 'tipe_kriteria', 'bobot', 'tahun'];
        foreach ($fieldsToTrack as $field) {
            if ($kriteria->$field != $request->$field) {
                \App\Models\KriteriaHistory::create([
                    'kriteria_id' => $kriteria->id,
                    'user_id' => auth()->id(),
                    'field' => $field,
                    'old_value' => $kriteria->$field,
                    'new_value' => $request->$field,
                    'changed_at' => now(),
                ]);
            }
        }
        $kriteria->update(array_merge(
            $request->only(['kode_kriteria', 'nama_kriteria', 'keterangan_kriteria', 'tipe_kriteria', 'bobot', 'tahun']),
            ['periode_id' => $periode?->id]
        ));
        return redirect()->route('kriterias.index')->with('success', 'Kriteria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        // Ambil angka dari kode yang dihapus
        $deletedNum = null;
        if (preg_match('/K(\d+)/', $kriteria->kode_kriteria, $m)) {
            $deletedNum = (int)$m[1];
        }
        $kriteria->delete();
        // Update kode_kriteria setelahnya
        if ($deletedNum) {
            $kriteriasToUpdate = Kriteria::all()->filter(function($item) use ($deletedNum) {
                if (preg_match('/K(\d+)/', $item->kode_kriteria, $m)) {
                    return (int)$m[1] > $deletedNum;
                }
                return false;
            });
            foreach ($kriteriasToUpdate as $item) {
                if (preg_match('/K(\d+)/', $item->kode_kriteria, $m)) {
                    $newNum = (int)$m[1] - 1;
                    $item->kode_kriteria = 'K' . $newNum;
                    $item->save();
                }
            }
        }
        return redirect()->route('kriterias.index')->with('success', 'Kriteria deleted successfully.');
    }

    public function auditLog()
    {
        // Pastikan hanya user dengan permission view_audit_log yang bisa akses
        if (!auth()->user() || !auth()->user()->can('view_audit_log')) {
            abort(403, 'Unauthorized');
        }
        $logs = \App\Models\KriteriaHistory::with(['kriteria', 'user'])
            ->orderByDesc('changed_at')
            ->paginate(30);
        return view('kriterias.audit_log', compact('logs'));
    }

    public function auditLogPerKriteria($kriteriaId)
    {
        if (!auth()->user() || !auth()->user()->can('view_audit_log')) {
            abort(403, 'Unauthorized');
        }
        $kriteria = \App\Models\Kriteria::findOrFail($kriteriaId);
        $logs = \App\Models\KriteriaHistory::with(['user'])
            ->where('kriteria_id', $kriteriaId)
            ->orderByDesc('changed_at')
            ->paginate(30);
        return view('kriterias.audit_log_per_kriteria', compact('logs', 'kriteria'));
    }
}
