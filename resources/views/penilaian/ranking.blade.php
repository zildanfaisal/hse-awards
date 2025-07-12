<x-app-layout>
    <x-slot name="title">HSE Awards | Hasil Ranking</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Hasil Ranking Proyek HSE Awards') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($rankedProyeks->isEmpty())
                <div class="text-center text-gray-500 py-12 text-lg">
                    Belum ada proyek yang dinilai.
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                    {{-- Tabel Rekap Penilaian Proyek --}}
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
                                @foreach ($rankedProyeks as $i => $proyek)
                                    <tr>
                                        <td class="px-2 py-1 border">{{ $i + 1 }}</td>
                                        <td class="px-2 py-1 border">{{ $proyek->kode_proyek }}</td>
                                        <td class="px-2 py-1 border">{{ $proyek->manajerProyek ? $proyek->manajerProyek->nama_manajer : '-' }}</td>
                                        @foreach ($kriterias as $kriteria)
                                            @php
                                                $penilaian = \App\Models\Penilaian::where('proyek_id', $proyek->id)
                                                    ->where('kriteria_id', $kriteria->id)
                                                    ->first();
                                            @endphp
                                            <td class="px-2 py-1 border">
                                                @if ($penilaian && $penilaian->subKriteria)
                                                    {{ $penilaian->subKriteria->nilai_sub_kriteria }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($rankedProyeks->isNotEmpty())
                    <!-- Tabel Tahap 2: MAX, MIN, Selisih -->
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
                                            $criteriaDetails = $debugDetails[$rankedProyeks->first()->id]['criteria_details'];
                                            $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                        @endphp
                                        <td class="px-2 py-1 border">{{ $c['max_value'] ?? '-' }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="px-2 py-1 border font-semibold">MIN</td>
                                    @foreach($kriterias as $kriteria)
                                        @php
                                            $criteriaDetails = $debugDetails[$rankedProyeks->first()->id]['criteria_details'];
                                            $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                        @endphp
                                        <td class="px-2 py-1 border">{{ $c['min_value'] ?? '-' }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="px-2 py-1 border font-semibold">Selisih</td>
                                    @foreach($kriterias as $kriteria)
                                        @php
                                            $criteriaDetails = $debugDetails[$rankedProyeks->first()->id]['criteria_details'];
                                            $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                        @endphp
                                        <td class="px-2 py-1 border">{{ (isset($c['max_value']) && isset($c['min_value'])) ? $c['max_value'] - $c['min_value'] : '-' }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Tahap 3: Normalisasi Nilai Utilitas -->
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
                                @foreach($rankedProyeks as $proyek)
                                <tr>
                                    <td class="px-2 py-1 border font-semibold">{{ $proyek->kode_proyek }}</td>
                                    @foreach($kriterias as $kriteria)
                                        @php
                                            $criteriaDetails = $debugDetails[$proyek->id]['criteria_details'];
                                            $c = collect($criteriaDetails)->firstWhere('kriteria_id', $kriteria->id);
                                        @endphp
                                        <td class="px-2 py-1 border">{{ isset($c['adjusted_utility_value']) ? number_format($c['adjusted_utility_value'], 6) : '-' }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Tahap 4: Perkalian Nilai Utilitas dengan Bobot Kriteria -->
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
                                @foreach($rankedProyeks as $proyek)
                                <tr>
                                    <td class="px-2 py-1 border font-semibold">{{ $proyek->kode_proyek }}</td>
                                    @foreach($kriterias as $kriteria)
                                        @php
                                            $criteriaDetails = $debugDetails[$proyek->id]['criteria_details'];
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
                    <h3 class="font-bold text-lg mb-2">Tahap 4: Perangkingan HSE Awards</h3>
                    <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                        <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Peringkat</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Proyek</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Proyek</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Manajer Proyek</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Skor MAUT</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-center">
                            @php $sortedProyeks = $rankedProyeks->sortByDesc('maut_score')->values(); @endphp
                            @forelse ($sortedProyeks as $proyek)
                            <tr class="hover:bg-blue-50 transition text-center align-middle">
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->kode_proyek }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->nama_proyek }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->manajerProyek ? $proyek->manajerProyek->nama_manajer : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ number_format($proyek->maut_score, 6) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada proyek yang dinilai atau data tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($rankedProyeks->isNotEmpty())
                        <form action="{{ route('penilaian.save_ranking') }}" method="POST" class="mt-4 p-4 border rounded-md">
                            @csrf
                            <input type="hidden" name="calculation_method" value="{{ $method ?? 'absolute' }}">
                            <h4 class="font-semibold mb-2">Simpan Hasil Ranking Ini:</h4>
                            <div class="mb-3">
                                <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi Ranking (Opsional):</label>
                                <input type="text" name="nama_sesi" id="nama_sesi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Ranking HSE Awards Periode Juni 2025">
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan/Kesimpulan (Opsional):</label>
                                <textarea name="catatan" id="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Tambahkan kesimpulan atau catatan penting untuk sesi ranking ini."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="calculated_at" class="block text-sm font-medium text-gray-700">Tanggal Ranking:</label>
                                <input type="datetime-local" name="calculated_at" id="calculated_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Simpan Ranking Final</button>
                        </form>
                    @endif

                    {{-- @if(Auth::user() && Auth::user()->role === 'super-admin')
                    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <h3 class="font-bold text-yellow-700 mb-2">Debug Perhitungan MAUT (PHP)</h3>
                        @foreach($rankedProyeks as $proyek)
                            <div class="mb-4">
                                <div class="font-semibold text-gray-800">{{ $proyek->nama_proyek }} ({{ $proyek->kode_proyek }})</div>
                                <div class="text-sm text-gray-700">Skor Akhir: <span class="font-mono">{{ number_format($debugDetails[$proyek->id]['final_maut_score'], 6) }}</span></div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-max mt-2 mb-2 text-xs border border-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-2 py-1 border">Kriteria</th>
                                                <th class="px-2 py-1 border">Tipe</th>
                                                <th class="px-2 py-1 border">Bobot</th>
                                                <th class="px-2 py-1 border">Utility Value</th>
                                                <th class="px-2 py-1 border">Min Value</th>
                                                <th class="px-2 py-1 border">Max Value</th>
                                                <th class="px-2 py-1 border">Normalized Utility (0-1)</th>
                                                <th class="px-2 py-1 border">Bobot x Normalized</th>
                                                <th class="px-2 py-1 border">Utility (Cost?)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($debugDetails[$proyek->id]['criteria_details'] as $c)
                                            <tr>
                                                <td class="px-2 py-1 border">{{ $c['nama_kriteria'] }}</td>
                                                <td class="px-2 py-1 border">{{ $c['tipe_kriteria'] }}</td>
                                                <td class="px-2 py-1 border">{{ $c['original_weight'] }}</td>
                                                <td class="px-2 py-1 border">{{ $c['raw_utility_value'] ?? '-' }}</td>
                                                <td class="px-2 py-1 border">{{ $c['min_value'] ?? '-' }}</td>
                                                <td class="px-2 py-1 border">{{ $c['max_value'] ?? '-' }}</td>
                                                <td class="px-2 py-1 border">{{ isset($c['normalized_utility_value']) ? number_format($c['normalized_utility_value'], 6) : '-' }}</td>
                                                <td class="px-2 py-1 border">{{ isset($c['bobot_x_normalized']) ? number_format($c['bobot_x_normalized'], 6) : '-' }}</td>
                                                <td class="px-2 py-1 border">{{ isset($c['adjusted_utility_value']) ? number_format($c['adjusted_utility_value'], 4) : '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif --}}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>