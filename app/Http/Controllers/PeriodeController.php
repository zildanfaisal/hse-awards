<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PeriodeController extends Controller
{
    // Tampilkan daftar periode dan periode aktif
    public function index()
    {
        $periodes = Periode::orderByDesc('nama_periode')->get();
        $activePeriode = Periode::getActivePeriode();
        return view('periodes.index', compact('periodes', 'activePeriode'));
    }

    // Simpan periode baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255|unique:periodes,nama_periode',
        ]);
        Periode::create([
            'nama_periode' => $request->nama_periode,
            'is_active' => false,
        ]);
        return redirect()->route('periodes.index')->with('success', 'Periode baru berhasil ditambahkan.');
    }

    // Set periode aktif
    public function setActive($id)
    {
        // Nonaktifkan semua periode
        Periode::query()->update(['is_active' => false]);
        // Aktifkan periode yang dipilih
        $periode = Periode::findOrFail($id);
        $periode->is_active = true;
        $periode->save();
        return redirect()->route('periodes.index')->with('success', 'Periode aktif berhasil diubah.');
    }
} 