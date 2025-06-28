<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisProyek;

class JenisProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis = JenisProyek::all();
        return view('jenis_proyeks.index', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_proyeks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jenis' => 'required|string|unique:jenis_proyeks,kode_jenis',
            'nama_jenis' => 'required|string',
        ]);
        JenisProyek::create($request->only('kode_jenis', 'nama_jenis'));
        return redirect()->route('jenis-proyeks.index')->with('success', 'Jenis proyek berhasil ditambahkan.');
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
    public function edit($id)
    {
        $jenis = JenisProyek::findOrFail($id);
        return view('jenis_proyeks.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenis = JenisProyek::findOrFail($id);
        $request->validate([
            'kode_jenis' => 'required|string|unique:jenis_proyeks,kode_jenis,' . $jenis->id,
            'nama_jenis' => 'required|string',
        ]);
        $jenis->update($request->only('kode_jenis', 'nama_jenis'));
        return redirect()->route('jenis-proyeks.index')->with('success', 'Jenis proyek berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenis = JenisProyek::findOrFail($id);
        $jenis->delete();
        return redirect()->route('jenis-proyeks.index')->with('success', 'Jenis proyek berhasil dihapus.');
    }
}
