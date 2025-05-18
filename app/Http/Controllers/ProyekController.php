<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyeks = Proyek::all();
        return view('proyeks.index', compact('proyeks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proyeks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_proyek' => 'required|string|max:255|unique:proyeks',
            'nama_proyek' => 'required|string|max:255',
            'manajer_proyek' => 'required|string|max:255',
            'jenis_proyek' => 'required|string|max:255',
            'lokasi_proyek' => 'required|string|max:255',
        ]);

        Proyek::create($request->all());

        return redirect()->route('proyeks.index')->with('success', 'Proyek created successfully.');
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
    public function edit(Proyek $proyek)
    {
        return view('proyeks.edit', compact('proyek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyek $proyek)
    {
        $request->validate([
            'kode_proyek' => 'required|string|max:255|unique:proyeks,kode_proyek,' . $proyek->id,
            'nama_proyek' => 'required|string|max:255',
            'manajer_proyek' => 'required|string|max:255',
            'jenis_proyek' => 'required|string|max:255',
            'lokasi_proyek' => 'required|string|max:255',
        ]);

        $proyek->update($request->all());

        return redirect()->route('proyeks.index')->with('success', 'Proyek updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();

        return redirect()->route('proyeks.index')->with('success', 'Proyek deleted successfully.');
    }
}
