<x-app-layout>
    <x-slot name="title">HSE Awards | Detail Ranking: {{ $rankingBatch->nama_sesi ?? 'Tanpa Nama Sesi' }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Hasil Ranking: ') }} {{ $rankingBatch->nama_sesi ?? 'Tanpa Nama Sesi' }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                @can('laporan')
                <div class="flex justify-start mb-2">
                    <a href="{{ route('awards.history.export_pdf_detail', $rankingBatch->id) }}" target="_blank" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow text-sm font-semibold">Export PDF</a>
                    </div>
                @endcan
                <p class="mb-2"><strong>Dihitung Oleh:</strong> {{ $rankingBatch->user->name ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Tanggal Dihitung:</strong> {{ $rankingBatch->calculated_at->format('d M Y H:i') }}</p>
                @if ($rankingBatch->catatan)
                    <p class="mb-4"><strong>Catatan/Kesimpulan:</strong> {{ $rankingBatch->catatan }}</p>
                @endif

                {{-- Tabel 1: Daftar Proyek yang Mengikuti Penilaian --}}
                <h3 class="font-bold text-lg mb-2">Daftar Proyek yang Mengikuti Penilaian</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">No</th>
                                <th class="px-2 py-1 border">Kode Proyek</th>
                                <th class="px-2 py-1 border">Nama Proyek</th>
                                <th class="px-2 py-1 border">Manajer Proyek</th>
                                <th class="px-2 py-1 border">Jenis Proyek</th>
                                <th class="px-2 py-1 border">Lokasi Proyek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rankedDetails as $i => $detail)
                                <tr>
                                    <td class="px-2 py-1 border">{{ $i + 1 }}</td>
                                    <td class="px-2 py-1 border">{{ $detail->proyek->kode_proyek ?? '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $detail->proyek->nama_proyek ?? '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $detail->proyek && $detail->proyek->manajerProyek ? $detail->proyek->manajerProyek->nama_manajer : '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $detail->proyek && $detail->proyek->jenisProyek ? $detail->proyek->jenisProyek->nama_jenis : '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $detail->proyek->lokasi_proyek ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tabel 2: Daftar Kriteria Penilaian --}}
                <h3 class="font-bold text-lg mb-2">Daftar Kriteria Penilaian</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">No</th>
                                <th class="px-2 py-1 border">Kode Kriteria</th>
                                <th class="px-2 py-1 border">Nama Kriteria</th>
                                <th class="px-2 py-1 border">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriterias as $i => $kriteria)
                                <tr>
                                    <td class="px-2 py-1 border">{{ $i + 1 }}</td>
                                    <td class="px-2 py-1 border">{{ $kriteria->kode_kriteria }}</td>
                                    <td class="px-2 py-1 border">{{ $kriteria->nama_kriteria }}</td>
                                    <td class="px-2 py-1 border">{{ $kriteria->bobot }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tabel 3: Daftar Sub-Kriteria Penilaian --}}
                <h3 class="font-bold text-lg mb-2">Daftar Sub-Kriteria Penilaian</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">No</th>
                                <th class="px-2 py-1 border">Kode Sub-Kriteria</th>
                                <th class="px-2 py-1 border">Nama Sub-Kriteria</th>
                                <th class="px-2 py-1 border">Kriteria</th>
                                <th class="px-2 py-1 border">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subkriterias as $i => $sub)
                                <tr>
                                    <td class="px-2 py-1 border">{{ $i + 1 }}</td>
                                    <td class="px-2 py-1 border">{{ $sub->kode_sub_kriteria }}</td>
                                    <td class="px-2 py-1 border">{{ $sub->nama_sub_kriteria }}</td>
                                    <td class="px-2 py-1 border">{{ $sub->kriteria ? $sub->kriteria->nama_kriteria : '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $sub->nilai_sub_kriteria }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tabel 4: Rekap Penilaian Proyek --}}
                @php
                    $assessmentDetails = $rankingBatch->assessment_details ? json_decode($rankingBatch->assessment_details, true) : [];
                    // Ambil urutan proyek_id sesuai urutan input
                    $proyekIds = collect($assessmentDetails)->pluck('proyek_id')->unique()->values();
                @endphp
                <h3 class="font-bold text-lg mb-2">Rekap Penilaian Proyek</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">No</th>
                                <th class="px-2 py-1 border">Kode Proyek</th>
                                <th class="px-2 py-1 border">Manajer Proyek</th>
                                @foreach ($kriterias as $kriteria)
                                    <th class="px-2 py-1 border">{{ $kriteria->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proyekIds as $i => $proyekId)
                                @php
                                    $proyek = \App\Models\Proyek::with('manajerProyek')->find($proyekId);
                                @endphp
                                <tr>
                                    <td class="px-2 py-1 border">{{ $i + 1 }}</td>
                                    <td class="px-2 py-1 border">{{ $proyek ? $proyek->kode_proyek : '-' }}</td>
                                    <td class="px-2 py-1 border">{{ $proyek && $proyek->manajerProyek ? $proyek->manajerProyek->nama_manajer : '-' }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @php
                                            $penilaian = collect($assessmentDetails)->first(function($p) use ($proyekId, $kriteria) {
                                                return $p['proyek_id'] == $proyekId && $p['kriteria_id'] == $kriteria->id;
                                            });
                                        @endphp
                                        <td class="px-2 py-1 border">
                                            {{ $penilaian['nilai_sub_kriteria'] ?? '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tabel Tahapan Proses Perhitungan (seperti di PDF) --}}
                @php
                    $debugDetails = $rankingBatch->calculation_details ? json_decode($rankingBatch->calculation_details, true) : null;
                    $firstDetail = $debugDetails ? reset($debugDetails) : null;
                @endphp
                @if($debugDetails && $firstDetail)
                <h3 class="font-bold text-lg mb-2">Tahap 1: Mencari Nilai MAX, MIN, dan Selisih</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">MAX/MIN</th>
                                @foreach($kriterias as $kriteria)
                                    <th class="px-2 py-1 border">{{ $kriteria->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border font-semibold">MAX</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $criteriaDetails = $firstDetail['criteria_details'];
                                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                    @endphp
                                    <td class="px-2 py-1 border">{{ $c['max_value'] ?? '-' }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border font-semibold">MIN</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $criteriaDetails = $firstDetail['criteria_details'];
                                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                    @endphp
                                    <td class="px-2 py-1 border">{{ $c['min_value'] ?? '-' }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border font-semibold">Selisih</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $criteriaDetails = $firstDetail['criteria_details'];
                                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                    @endphp
                                    <td class="px-2 py-1 border">{{ (isset($c['max_value']) && isset($c['min_value'])) ? $c['max_value'] - $c['min_value'] : '-' }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-lg mb-2">Tahap 2: Normalisasi Nilai Utilitas</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">Kode Proyek</th>
                                @foreach($kriterias as $kriteria)
                                    <th class="px-2 py-1 border">{{ $kriteria->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($debugDetails as $proyekId => $detail)
                            @php
                                $proyek = \App\Models\Proyek::find($detail['proyek_id'] ?? null);
                            @endphp
                            <tr>
                                <td class="px-2 py-1 border font-semibold">{{ $proyek ? $proyek->kode_proyek : '-' }}</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $criteriaDetails = $detail['criteria_details'];
                                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                    @endphp
                                    <td class="px-2 py-1 border">{{ isset($c['adjusted_utility_value']) ? number_format($c['adjusted_utility_value'], 6) : '-' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-lg mb-2">Tahap 3: Perkalian Nilai Utilitas dengan Bobot Kriteria</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full table-auto text-xs border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">Kode Proyek</th>
                                @foreach($kriterias as $kriteria)
                                    <th class="px-2 py-1 border">{{ $kriteria->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($debugDetails as $proyekId => $detail)
                            @php
                                $proyek = \App\Models\Proyek::find($detail['proyek_id'] ?? null);
                            @endphp
                            <tr>
                                <td class="px-2 py-1 border font-semibold">{{ $proyek ? $proyek->kode_proyek : '-' }}</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $criteriaDetails = $detail['criteria_details'];
                                        $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                    @endphp
                                    <td class="px-2 py-1 border">{{ isset($c['bobot_x_normalized']) ? number_format($c['bobot_x_normalized'], 6) : '-' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4 mt-6">Detail Peringkat Proyek:</h3>

                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Skor MAUT</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @php $sortedProyeks = $rankedDetails->sortByDesc('final_maut_score')->values(); @endphp
                        @foreach ($sortedProyeks as $detail)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek->kode_proyek ?? 'Proyek Dihapus' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek->nama_proyek ?? 'Proyek Dihapus' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek && $detail->proyek->manajerProyek ? $detail->proyek->manajerProyek->nama_manajer : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($detail->final_maut_score, 6) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-start">
                    <a href="{{ route('awards.history') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Kembali ke Riwayat Ranking</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>