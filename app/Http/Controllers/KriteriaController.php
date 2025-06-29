<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Sub_kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Validate the request data
        $request->validate([
            'kode_kriteria' => 'required|string|max:255',
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
        // Cek permission user
        $canEdit = Auth::user()->can('kriteria.edit');
        $canInputBobot = Auth::user()->can('kriteria.input_bobot');
        
        if (!$canEdit && !$canInputBobot) {
            abort(403, 'Unauthorized action.');
        }
        
        // Jika hanya bisa input bobot, hanya validasi dan update bobot
        if (!$canEdit && $canInputBobot) {
            $request->validate([
                'bobot' => 'required|numeric',
            ]);
            
            $newBobot = $request->bobot;
            
            // Ambil bobot yang ada
            $total_bobot = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');
            
            // Cek apakah total bobot sudah 1
            if (($total_bobot + $newBobot) > 1) {
                return redirect()->back()->withInput()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 1.']);
            }
            
            // Update hanya bobot
            $kriteria->update(['bobot' => $newBobot]);
            
            return redirect()->route('kriterias.index')->with('success', 'Bobot kriteria berhasil diperbarui.');
        }
        
        // Jika punya permission edit penuh, validasi dan update semua field
        $request->validate([
            'kode_kriteria' => 'nullable|string|max:255',
            'nama_kriteria' => 'required|string|max:255',
            'keterangan_kriteria' => 'string|max:255',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
        ]);

        // Ambil bobot yang ada
        $total_bobot = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');

        // Cek apakah total bobot sudah 1
        if (($total_bobot + $request->bobot) > 1) {
            return redirect()->back()->withInput()->withErrors(['bobot' => 'Total bobot tidak boleh lebih dari 1.']);
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
}
