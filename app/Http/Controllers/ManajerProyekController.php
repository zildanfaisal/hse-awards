<?php

namespace App\Http\Controllers;

use App\Models\ManajerProyek;
use Illuminate\Http\Request;

class ManajerProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manajers = ManajerProyek::all();
        return view('manajer_proyeks.index', compact('manajers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari kode manajer terakhir
        $lastKode = ManajerProyek::orderByDesc('id')->value('kode_manajer');
        $nextKode = 'M-1';
        if ($lastKode && preg_match('/M-(\d+)/', $lastKode, $m)) {
            $nextKode = 'M-' . ((int)$m[1] + 1);
        } elseif (ManajerProyek::count() > 0) {
            $nextKode = 'M-' . (ManajerProyek::count() + 1);
        }
        return view('manajer_proyeks.create', ['nextKodeManajer' => $nextKode]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_manajer' => 'required|string|unique:manajer_proyeks,kode_manajer',
            'nama_manajer' => 'required|string',
        ]);
        ManajerProyek::create($request->only('kode_manajer', 'nama_manajer'));
        return redirect()->route('manajer-proyeks.index')->with('success', 'Manajer berhasil ditambahkan.');
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
        $manajer = ManajerProyek::findOrFail($id);
        return view('manajer_proyeks.edit', compact('manajer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $manajer = ManajerProyek::findOrFail($id);
        $request->validate([
            'kode_manajer' => 'required|string|unique:manajer_proyeks,kode_manajer,' . $manajer->id,
            'nama_manajer' => 'required|string',
        ]);
        $manajer->update($request->only('kode_manajer', 'nama_manajer'));
        return redirect()->route('manajer-proyeks.index')->with('success', 'Manajer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manajer = ManajerProyek::findOrFail($id);
        // Ambil angka dari kode yang dihapus
        $deletedNum = null;
        if (preg_match('/M-(\d+)/', $manajer->kode_manajer, $m)) {
            $deletedNum = (int)$m[1];
        }
        $manajer->delete();
        // Update kode_manajer setelahnya
        if ($deletedNum) {
            $manajersToUpdate = ManajerProyek::all()->filter(function($item) use ($deletedNum) {
                if (preg_match('/M-(\d+)/', $item->kode_manajer, $m)) {
                    return (int)$m[1] > $deletedNum;
                }
                return false;
            });
            foreach ($manajersToUpdate as $item) {
                if (preg_match('/M-(\d+)/', $item->kode_manajer, $m)) {
                    $newNum = (int)$m[1] - 1;
                    $item->kode_manajer = 'M-' . $newNum;
                    $item->save();
                }
            }
        }
        return redirect()->route('manajer-proyeks.index')->with('success', 'Manajer berhasil dihapus.');
    }
}
