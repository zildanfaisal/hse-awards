<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $groupSubKriterias = SubKriteria::with('kriteria')->get()->groupBy(function($item) {
        //     return $item->kriteria->nama_kriteria;
        // });

        // return view('subkriterias.index', compact('groupSubKriterias'));

        $subkriterias = SubKriteria::with('kriteria')->get();

        // Group by kriteria_id, lalu ambil semua kriteria
        $groupSubKriterias = $subkriterias->groupBy('kriteria_id');

        $kriterias = Kriteria::all()->keyBy('id'); // agar mudah ambil nama & bobot berdasarkan id

        return view('subkriterias.index', compact('groupSubKriterias', 'kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('subkriterias.create', compact('kriterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'keterangan_sub_kriteria' => 'string|max:255',
            'nilai_sub_kriteria' => 'required|numeric',
        ]);

        SubKriteria::create($request->all());

        // Redirect to the index page with a success message
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
        $kriterias = Kriteria::all();
        return view('subkriterias.edit', compact('subkriteria', 'kriterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubKriteria $subkriteria)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'keterangan_sub_kriteria' => 'string|max:255',
            'nilai_sub_kriteria' => 'required|numeric',
        ]);

        $subkriteria->update($request->all());
        return redirect()->route('subkriterias.index')->with('success', 'Sub-Kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKriteria $subkriteria)
    {
        $subkriteria->delete();

        return redirect()->route('subkriterias.index')->with('success', 'Sub-Kriteria berhasil dihapus.');
    }
}
