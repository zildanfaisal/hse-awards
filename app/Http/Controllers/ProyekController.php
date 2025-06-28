<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ManajerProyek;
use App\Models\JenisProyek;
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
        $manajers = ManajerProyek::all();
        $jenisList = JenisProyek::all();
        // Generate kode proyek otomatis
        $lastKode = Proyek::orderByDesc('id')->value('kode_proyek');
        $nextKode = 'KP-01';
        if ($lastKode && preg_match('/KP-(\d+)/', $lastKode, $m)) {
            $nextKode = 'KP-' . str_pad(((int)$m[1] + 1), 2, '0', STR_PAD_LEFT);
        } elseif (Proyek::count() > 0) {
            $nextKode = 'KP-' . str_pad((Proyek::count() + 1), 2, '0', STR_PAD_LEFT);
        }
        return view('proyeks.create', compact('manajers', 'jenisList', 'nextKode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_proyek' => 'required|string|max:255|unique:proyeks',
            'nama_proyek' => 'required|string|max:255',
            'manajer_proyek_id' => 'required|exists:manajer_proyeks,id',
            'jenis_proyek_id' => 'required|exists:jenis_proyeks,id',
            'lokasi_proyek' => 'required|string|max:255',
        ]);
        Proyek::create($request->only(['kode_proyek', 'nama_proyek', 'manajer_proyek_id', 'jenis_proyek_id', 'lokasi_proyek']));
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
        $manajers = ManajerProyek::all();
        $jenisList = JenisProyek::all();
        return view('proyeks.edit', compact('proyek', 'manajers', 'jenisList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyek $proyek)
    {
        $request->validate([
            'kode_proyek' => 'required|string|max:255|unique:proyeks,kode_proyek,' . $proyek->id,
            'nama_proyek' => 'required|string|max:255',
            'manajer_proyek_id' => 'required|exists:manajer_proyeks,id',
            'jenis_proyek_id' => 'required|exists:jenis_proyeks,id',
            'lokasi_proyek' => 'required|string|max:255',
        ]);
        $proyek->update($request->only(['kode_proyek', 'nama_proyek', 'manajer_proyek_id', 'jenis_proyek_id', 'lokasi_proyek']));
        return redirect()->route('proyeks.index')->with('success', 'Proyek updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyek $proyek)
    {
        // Ambil angka dari kode yang dihapus
        $deletedNum = null;
        if (preg_match('/KP-(\d+)/', $proyek->kode_proyek, $m)) {
            $deletedNum = (int)$m[1];
        }
        $proyek->delete();
        // Update kode_proyek setelahnya
        if ($deletedNum) {
            $proyeksToUpdate = Proyek::all()->filter(function($item) use ($deletedNum) {
                if (preg_match('/KP-(\d+)/', $item->kode_proyek, $m)) {
                    return (int)$m[1] > $deletedNum;
                }
                return false;
            });
            foreach ($proyeksToUpdate as $item) {
                if (preg_match('/KP-(\d+)/', $item->kode_proyek, $m)) {
                    $newNum = (int)$m[1] - 1;
                    $item->kode_proyek = 'KP-' . str_pad($newNum, 2, '0', STR_PAD_LEFT);
                    $item->save();
                }
            }
        }
        return redirect()->route('proyeks.index')->with('success', 'Proyek deleted successfully.');
    }
}
