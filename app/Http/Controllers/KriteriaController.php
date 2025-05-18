<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Sub_kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all criteria from the database
        $kriterias = Kriteria::all();

        // Hitung Nilai Bobot
        $total_bobot = $kriterias->sum('bobot');

        // Return the view with the criteria data
        return view('kriterias.index', compact('kriterias', 'total_bobot'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'keterangan_kriteria' => 'string|max:255',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
        ]);

        // Ambil bobot yang ada
        $total_bobot = Kriteria::sum('bobot');

        // Cek apakah total bobot sudah 1
        if (($total_bobot + $request->bobot) > 1) {
            return redirect()->back()->withInput()->withErrors('error', 'Total bobot tidak boleh lebih dari 1.');
        }

        // Create a new Kriteria instance and save it to the database
        Kriteria::create($request->all());

        // Redirect to the index page with a success message
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
        // Validate the request data
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'keterangan_kriteria' => 'string|max:255',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
        ]);

        // Ambil bobot yang ada
        $total_bobot = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');

        // Cek apakah total bobot sudah 1
        if (($total_bobot + $request->bobot) > 1) {
            return redirect()->back()->withInput()->withErrors('error', 'Total bobot tidak boleh lebih dari 1.');
        }

        // Find the Kriteria by ID and update it
        $kriteria->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('kriterias.index')->with('success', 'Kriteria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        // Delete the Kriteria and its associated Sub_kriterias
        $kriteria->delete();

        // Redirect to the index page with a success message
        return redirect()->route('kriterias.index')->with('success', 'Kriteria deleted successfully.');
    }
}
