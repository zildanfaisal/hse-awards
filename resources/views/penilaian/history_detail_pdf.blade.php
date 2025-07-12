<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Perhitungan HSE Awards</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
        h2, h3 { margin-bottom: 8px; margin-top: 18px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 14px; font-size: 11px; }
        th, td { border: 1px solid #333; padding: 8px 8px; text-align: center; word-break: break-word; }
        th { background: #eee; font-weight: bold; text-align: center; }
        .section { margin-bottom: 18px; }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 18px;">
        <h2 style="margin-bottom: 8px;">Laporan Riwayat Perhitungan HSE Awards</h2>
        <img src="{{ public_path('img/logo-qhse.png') }}" alt="Logo QHSE" style="width: 130px; height: 130px; margin-bottom: 8px;">
        <div style="font-size: 16px; font-weight: bold; margin-bottom: 18px;">Health Safety and Environment Awards</div>
    </div>
    <table style="margin-bottom: 18px; margin-left: 0; border: none; width: auto; font-size: 12px;">
        <tr>
            <td style="padding: 2px 8px; border: none; text-align: left;"><strong>Nama Sesi</strong></td>
            <td style="padding: 2px 8px; border: none;">:</td>
            <td style="padding: 2px 8px; border: none; text-align: left;">{{ $rankingBatch->nama_sesi ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 2px 8px; border: none; text-align: left;"><strong>Dihitung Oleh</strong></td>
            <td style="padding: 2px 8px; border: none;">:</td>
            <td style="padding: 2px 8px; border: none; text-align: left;">{{ $rankingBatch->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 2px 8px; border: none; text-align: left;"><strong>Tanggal Dihitung</strong></td>
            <td style="padding: 2px 8px; border: none;">:</td>
            <td style="padding: 2px 8px; border: none; text-align: left;">{{ $rankingBatch->calculated_at ? $rankingBatch->calculated_at->format('d M Y') : '-' }}</td>
        </tr>
        @if ($rankingBatch->catatan)
        <tr>
            <td style="padding: 2px 8px; border: none; text-align: left;"><strong>Catatan/Kesimpulan</strong></td>
            <td style="padding: 2px 8px; border: none;">:</td>
            <td style="padding: 2px 8px; border: none; text-align: left;">{{ $rankingBatch->catatan }}</td>
        </tr>
        @endif
    </table>

    {{-- Tabel 1: Data Proyek yang Mengikuti Penilaian --}}
    <h3>Daftar Proyek yang Mengikuti Penilaian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Proyek</th>
                <th>Nama Proyek</th>
                <th>Manajer Proyek</th>
                <th>Jenis Proyek</th>
                <th>Lokasi Proyek</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankedDetails as $i => $detail)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $detail->proyek->kode_proyek ?? '-' }}</td>
                    <td>{{ $detail->proyek->nama_proyek ?? '-' }}</td>
                    <td>{{ $detail->proyek && $detail->proyek->manajerProyek ? $detail->proyek->manajerProyek->nama_manajer : '-' }}</td>
                    <td>{{ $detail->proyek && $detail->proyek->jenisProyek ? $detail->proyek->jenisProyek->nama_jenis : '-' }}</td>
                    <td>{{ $detail->proyek->lokasi_proyek ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tabel 2: Data Kriteria --}}
    {{-- <h3>Daftar Kriteria Penilaian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kriteria</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @php $kriterias = \App\Models\Kriteria::all();
            $totalBobot = $kriterias->sum('bobot');
            @endphp
            @foreach ($kriterias as $i => $kriteria)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $kriteria->kode_kriteria }}</td>
                    <td style="text-align:left;">{{ $kriteria->nama_kriteria }}</td>
                    <td>{{ $kriteria->bobot }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right; font-weight:bold;">Total</td>
                <td style="font-weight:bold;">{{ number_format($totalBobot, 4) }}</td>
            </tr>
        </tbody>
    </table> --}}

    {{-- Tabel 3: Data Sub-Kriteria --}}
    {{-- <h3>Daftar Sub-Kriteria Penilaian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Sub-Kriteria</th>
                <th>Nama Sub-Kriteria</th>
                <th>Kriteria</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php $subkriterias = \App\Models\SubKriteria::with('kriteria')->get(); @endphp
            @foreach ($subkriterias as $i => $sub)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $sub->kode_sub_kriteria }}</td>
                    <td style="text-align:left;">{{ $sub->nama_sub_kriteria }}</td>
                    <td style="text-align:left;">{{ $sub->kriteria ? $sub->kriteria->nama_kriteria : '-' }}</td>
                    <td>{{ $sub->nilai_sub_kriteria }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}

    {{-- Tabel 4: Data Penilaian yang Dilakukan --}}
    <h3>Rekap Penilaian Proyek</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Proyek</th>
                <th>Nama Proyek</th>
                @foreach ($kriterias as $kriteria)
                    <th>{{ $kriteria->kode_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $assessmentDetails = $rankingBatch->assessment_details ? json_decode($rankingBatch->assessment_details, true) : [];
            @endphp
            @foreach ($rankedDetails as $i => $detail)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $detail->proyek->kode_proyek ?? '-' }}</td>
                    <td>{{ $detail->proyek->nama_proyek ?? '-' }}</td>
                    @foreach ($kriterias as $kriteria)
                        @php
                            $penilaian = collect($assessmentDetails)->first(function($p) use ($detail, $kriteria) {
                                return $p['proyek_id'] == $detail->proyek->id && $p['kriteria_id'] == $kriteria->id;
                            });
                        @endphp
                        <td>
                            @if ($penilaian)
                                <span style="font-size:9px;">{{ $penilaian['nilai_sub_kriteria'] ?? '-' }}</span>
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- @if($debugDetails && $firstDetail)
    @php
        $kriterias = \App\Models\Kriteria::all();
    @endphp --}}
    {{-- Tabel Tahap 1: Mencari Nilai MAX, MIN, dan Selisih --}}
    {{-- <h3>Tahap 1: Mencari Nilai MAX, MIN, dan Selisih</h3>
    <table>
        <thead>
            <tr>
                <th>MAX/MIN</th>
                @foreach($kriterias as $kriteria)
                    <th>{{ $kriteria->kode_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MAX</td>
                @foreach($kriterias as $kriteria)
                    @php
                        $criteriaDetails = $firstDetail['criteria_details'];
                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                    @endphp
                    <td>{{ $c['max_value'] ?? '-' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>MIN</td>
                @foreach($kriterias as $kriteria)
                    @php
                        $criteriaDetails = $firstDetail['criteria_details'];
                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                    @endphp
                    <td>{{ $c['min_value'] ?? '-' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Selisih</td>
                @foreach($kriterias as $kriteria)
                    @php
                        $criteriaDetails = $firstDetail['criteria_details'];
                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                    @endphp
                    <td>{{ (isset($c['max_value']) && isset($c['min_value'])) ? $c['max_value'] - $c['min_value'] : '-' }}</td>
                @endforeach
            </tr>
        </tbody>
    </table> --}}

    {{-- <h3>Tahap 2: Normalisasi Nilai Utilitas</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Proyek</th>
                @foreach($kriterias as $kriteria)
                    <th>{{ $kriteria->kode_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($debugDetails as $proyekId => $detail)
            @php
                $proyek = \App\Models\Proyek::find($detail['proyek_id'] ?? null);
            @endphp
            <tr>
                <td>{{ $proyek ? $proyek->kode_proyek : '-' }}</td>
                @foreach($kriterias as $kriteria)
                    @php
                        $criteriaDetails = $detail['criteria_details'];
                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                    @endphp
                    <td>{{ isset($c['adjusted_utility_value']) ? number_format($c['adjusted_utility_value'], 4) : '-' }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table> --}}

    {{-- <h3>Tahap 3: Perkalian Nilai Utilitas dengan Bobot Kriteria</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Proyek</th>
                @foreach($kriterias as $kriteria)
                    <th>{{ $kriteria->kode_kriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($debugDetails as $proyekId => $detail)
            @php
                $proyek = \App\Models\Proyek::find($detail['proyek_id'] ?? null);
            @endphp
            <tr>
                <td>{{ $proyek ? $proyek->kode_proyek : '-' }}</td>
                @foreach($kriterias as $kriteria)
                    @php
                        $criteriaDetails = $detail['criteria_details'];
                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                    @endphp
                    <td>{{ isset($c['bobot_x_normalized']) ? number_format($c['bobot_x_normalized'], 4) : '-' }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif --}}

    <h3>Ranking Health Safety and Environment Awards</h3>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Kode Proyek</th>
                <th>Nama Proyek</th>
                <th>Manajer Proyek</th>
                <th>Skor MAUT</th>
            </tr>
        </thead>
        <tbody>
            @php $sortedProyeks = $rankedDetails->sortByDesc('final_maut_score')->values(); @endphp
            @foreach ($sortedProyeks as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->proyek->kode_proyek ?? 'Proyek Dihapus' }}</td>
                <td>{{ $detail->proyek->nama_proyek ?? 'Proyek Dihapus' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek && $detail->proyek->manajerProyek ? $detail->proyek->manajerProyek->nama_manajer : 'N/A' }}</td>
                <td>{{ number_format($detail->final_maut_score, 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 