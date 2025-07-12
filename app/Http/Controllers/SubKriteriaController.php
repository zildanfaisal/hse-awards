<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periode = Periode::getActivePeriode();
        $subkriterias = $periode ? SubKriteria::with('kriteria')->where('periode_id', $periode->id)->get() : collect();
        $tahunList = SubKriteria::where('periode_id', $periode?->id)->select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun')->toArray();
        $tahunTerbaru = $tahunList[0] ?? date('Y');
        $tahunDipilih = $request->get('tahun', $tahunTerbaru);
        $subkriterias = $subkriterias->where('tahun', $tahunDipilih);
        $groupSubKriterias = $subkriterias->groupBy('kriteria_id');
        $kriterias = \App\Models\Kriteria::where('periode_id', $periode?->id)->where('tahun', $tahunDipilih)->get()->keyBy('id');
        return view('subkriterias.index', compact('groupSubKriterias', 'kriterias', 'tahunList', 'tahunDipilih'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $periode = Periode::getActivePeriode();
        // Ambil list tahun dari kriteria pada periode aktif
        $tahunList = Kriteria::where('periode_id', $periode?->id)
            ->select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun')->toArray();
        // Ambil tahun dari request, jika tidak ada pakai tahun terbaru dari list
        $tahun = $request->get('tahun', $tahunList[0] ?? date('Y'));
        $kriterias = Kriteria::where('periode_id', $periode?->id)
            ->where('tahun', $tahun)
            ->get();
        $nextKode = null;
        $nextNilai = null;
        if ($kriterias->count() > 0) {
            $firstKriteria = $kriterias->first();
            $nextKode = $this->generateNextKode($firstKriteria->id);
            $nextNilai = $this->generateNextNilai($firstKriteria->id);
        }
        return view('subkriterias.create', compact('kriterias', 'nextKode', 'nextNilai', 'tahun', 'tahunList'));
    }

    // Helper untuk generate kode sub-kriteria berikutnya
    private function generateNextKode($kriteria_id) {
        $kriteria = Kriteria::find($kriteria_id);
        if (!$kriteria) return '';
        $kodeKriteria = $kriteria->kode_kriteria;
        $count = SubKriteria::where('kriteria_id', $kriteria_id)->count();
        $nextNum = $count + 1;
        return $kodeKriteria . '-SK' . $nextNum;
    }

    // Helper untuk generate nilai_sub_kriteria berikutnya
    private function generateNextNilai($kriteria_id) {
        $max = SubKriteria::where('kriteria_id', $kriteria_id)->max('nilai_sub_kriteria');
        return $max ? $max + 1 : 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'keterangan_sub_kriteria' => 'string|max:255',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);
        $periode = Periode::getActivePeriode();
        $kode_sub_kriteria = $this->generateNextKode($request->kriteria_id);
        $nilai_sub_kriteria = $this->generateNextNilai($request->kriteria_id);
        $data = $request->all();
        $data['kode_sub_kriteria'] = $kode_sub_kriteria;
        $data['nilai_sub_kriteria'] = $nilai_sub_kriteria;
        $data['periode_id'] = $periode?->id;
        SubKriteria::create($data);
        return redirect()->route('subkriterias.index')->with('success', 'Sub-Kriteria berhasil ditambahkan.');
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
    public function edit(SubKriteria $subkriteria)
    {
        $periode = Periode::getActivePeriode();
        $tahun = $subkriteria->tahun;
        $kriterias = Kriteria::where('periode_id', $periode?->id)
            ->where('tahun', $tahun)
            ->get();
        return view('subkriterias.edit', compact('subkriteria', 'kriterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubKriteria $subkriteria)
    {
        $canEdit = Auth::user()->can('sub_kriteria.edit');
        $canInputBobot = Auth::user()->can('sub_kriteria.input_bobot');
        if (!$canEdit && !$canInputBobot) {
            abort(403, 'Unauthorized action.');
        }
        if (!$canEdit && $canInputBobot) {
            $request->validate([
                'nilai_sub_kriteria' => 'required|numeric',
            ]);
            $newNilai = $request->nilai_sub_kriteria;
            $exists = SubKriteria::where('kriteria_id', $subkriteria->kriteria_id)
                ->where('id', '!=', $subkriteria->id)
                ->where('nilai_sub_kriteria', $newNilai)
                ->exists();
            if ($exists) {
                return redirect()->back()->withInput()->withErrors(['nilai_sub_kriteria' => 'Nilai sudah digunakan pada sub-kriteria lain.']);
            }
            $subkriteria->update(['nilai_sub_kriteria' => $newNilai]);
            $this->shiftNilaiSubKriteria($subkriteria->kriteria_id);
            return redirect()->route('subkriterias.index')->with('success', 'Bobot sub-kriteria berhasil diperbarui.');
        }
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'keterangan_sub_kriteria' => 'string|max:255',
            'nilai_sub_kriteria' => 'required|numeric',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);
        $oldKriteriaId = $subkriteria->kriteria_id;
        $oldNilai = $subkriteria->nilai_sub_kriteria;
        $newKriteriaId = $request->kriteria_id;
        $newNilai = $request->nilai_sub_kriteria;
        $exists = SubKriteria::where('kriteria_id', $newKriteriaId)
            ->where('id', '!=', $subkriteria->id)
            ->where('nilai_sub_kriteria', $newNilai)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['nilai_sub_kriteria' => 'Nilai sudah digunakan pada sub-kriteria lain.']);
        }
        $data = $request->except('kode_sub_kriteria');
        if ($oldKriteriaId != $newKriteriaId) {
            $data['kode_sub_kriteria'] = $this->generateNextKode($newKriteriaId);
        }
        $data['tahun'] = $request->tahun;
        $data['periode_id'] = Periode::getActivePeriode()?->id;
        $subkriteria->update($data);
        $this->shiftNilaiSubKriteria($oldKriteriaId);
        if ($oldKriteriaId != $newKriteriaId) {
            $this->shiftKodeSubKriteria($oldKriteriaId);
            $this->shiftNilaiSubKriteria($newKriteriaId);
        }
        $allNilai = SubKriteria::where('kriteria_id', $newKriteriaId)->orderBy('nilai_sub_kriteria')->pluck('nilai_sub_kriteria')->toArray();
        foreach ($allNilai as $i => $val) {
            if ($val != $i + 1) {
                return redirect()->back()->withInput()->withErrors(['nilai_sub_kriteria' => 'Urutan nilai harus berurutan tanpa loncatan.']);
            }
        }
        return redirect()->route('subkriterias.index')->with('success', 'Sub-Kriteria berhasil diperbarui.');
    }

    // Helper untuk auto-shift kode_sub_kriteria pada kriteria tertentu
    private function shiftKodeSubKriteria($kriteria_id) {
        $subKriterias = SubKriteria::where('kriteria_id', $kriteria_id)
            ->orderBy('kode_sub_kriteria')
            ->get();
        $kriteria = Kriteria::find($kriteria_id);
        if ($kriteria) {
            $kodeKriteria = $kriteria->kode_kriteria;
            $i = 1;
            foreach ($subKriterias as $sk) {
                $newKode = $kodeKriteria . '-SK' . $i;
                if ($sk->kode_sub_kriteria !== $newKode) {
                    $sk->kode_sub_kriteria = $newKode;
                    $sk->save();
                }
                $i++;
            }
        }
    }

    // Helper untuk auto-shift nilai_sub_kriteria pada kriteria tertentu
    private function shiftNilaiSubKriteria($kriteria_id) {
        $subKriterias = SubKriteria::where('kriteria_id', $kriteria_id)
            ->orderBy('nilai_sub_kriteria')
            ->get();
        $i = 1;
        foreach ($subKriterias as $sk) {
            if ($sk->nilai_sub_kriteria != $i) {
                $sk->nilai_sub_kriteria = $i;
                $sk->save();
            }
            $i++;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKriteria $subkriteria)
    {
        $kriteria_id = $subkriteria->kriteria_id;
        $subkriteria->delete();
        // Shift kode_sub_kriteria setelahnya
        $this->shiftKodeSubKriteria($kriteria_id);
        // Shift nilai_sub_kriteria setelahnya
        $this->shiftNilaiSubKriteria($kriteria_id);
        return redirect()->route('subkriterias.index')->with('success', 'Sub-Kriteria berhasil dihapus.');
    }

    // Endpoint AJAX untuk generate kode sub-kriteria berikutnya
    public function getNextKode(Request $request)
    {
        $kriteria_id = $request->input('kriteria_id');
        $kode = $this->generateNextKode($kriteria_id);
        return response()->json(['kode' => $kode]);
    }

    // Endpoint AJAX untuk generate nilai_sub_kriteria berikutnya
    public function getNextNilai(Request $request)
    {
        $kriteria_id = $request->input('kriteria_id');
        $nilai = $this->generateNextNilai($kriteria_id);
        return response()->json(['nilai' => $nilai]);
    }
}
