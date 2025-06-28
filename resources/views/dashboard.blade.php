<x-app-layout>
    <x-slot name="title">
        HSE Awards | Dashboard
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <!-- Box Data Proyek -->
                <a href="{{ route('proyeks.index') }}" class="block group">
                    <div class="bg-white border border-blue-100 shadow-lg rounded-2xl p-6 transition-transform duration-200 group-hover:-translate-y-1 group-hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gradient-to-tr from-blue-400 to-indigo-500 text-white mr-4 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Data Proyek</h3>
                                <p class="text-2xl font-bold text-blue-700">{{ $totalProyek }} Proyek</p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Box Data Ranking -->
                <a href="{{ route('awards.history') }}" class="block group">
                    <div class="bg-white border border-yellow-100 shadow-lg rounded-2xl p-6 transition-transform duration-200 group-hover:-translate-y-1 group-hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gradient-to-tr from-yellow-400 to-orange-500 text-white mr-4 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Data Ranking</h3>
                                <p class="text-2xl font-bold text-yellow-600">{{ $totalRanking }} Ranking</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Box Data Kriteria -->
                <a href="{{ route('kriterias.index') }}" class="block group">
                    <div class="bg-white border border-green-100 shadow-lg rounded-2xl p-6 transition-transform duration-200 group-hover:-translate-y-1 group-hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gradient-to-tr from-green-400 to-emerald-500 text-white mr-4 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Data Kriteria</h3>
                                <p class="text-2xl font-bold text-green-700">{{ $totalKriteria }} Kriteria</p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Box Data Sub Kriteria -->
                <a href="{{ route('subkriterias.index') }}" class="block group">
                    <div class="bg-white border border-purple-100 shadow-lg rounded-2xl p-6 transition-transform duration-200 group-hover:-translate-y-1 group-hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gradient-to-tr from-purple-400 to-fuchsia-500 text-white mr-4 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Data Sub Kriteria</h3>
                                <p class="text-2xl font-bold text-purple-700">{{ $totalSubKriteria }} Sub Kriteria</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Grafik Skor Proyek dari Riwayat Ranking</h3>
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <canvas id="rankingBarChart" height="120"></canvas>
                </div>
            </div> --}}

            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-700">Riwayat Ranking Terbaru</h3>
                    <a href="{{ route('awards.history') }}" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                        <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Sesi</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Pemenang</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Dihitung Oleh</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Tanggal Dihitung</th>
                                @can('penilaian')
                                    <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-center">
                            @forelse ($recentRankingBatches as $batch)
                            <tr class="hover:bg-blue-50 transition cursor-pointer text-center align-middle" onclick="window.location='{{ route('awards.history.detail', $batch['id']) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch['nama_sesi'] ?? 'Tanpa Nama Sesi' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                    {{ $batch['details'][0]['proyek'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch['user_name'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch['calculated_at'] ?? '-' }}</td>
                                @can('penilaian')
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle" onclick="event.stopPropagation();">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('awards.history.edit', $batch['id']) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $batch['id'] }}" action="{{ route('awards.history.destroy', $batch['id']) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDashboard({{ $batch['id'] }})" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->can('penilaian') ? 4 : 3 }}" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat ranking yang tersimpan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-700">Proyek Terbaru</h3>
                <a href="{{ route('proyeks.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
            </div>

            <!-- Tabel Data Proyek -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Manajer Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Jenis Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Lokasi Proyek</th>
                            @can('data_proyek')
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @foreach ($recentProyek as $proyek)
                        <tr class="hover:bg-blue-50 transition text-center align-middle">
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->manajerProyek?->nama_manajer ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->jenisProyek?->nama_jenis ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->lokasi_proyek }}</td>
                            @can('data_proyek')
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('proyeks.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('proyeks.destroy', $proyek->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    function confirmDeleteDashboard(batchId) {
        Swal.fire({
            title: 'Yakin hapus riwayat ini?',
            text: "Anda tidak akan bisa mengembalikannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + batchId).submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rankingBatches = @json($recentRankingBatches);
        let labels = [];
        let data = [];
        let backgroundColors = [];
        let colorPalette = [
            '#2563eb', '#f59e42', '#10b981', '#a21caf', '#f43f5e', '#fbbf24', '#6366f1', '#14b8a6', '#eab308', '#0ea5e9',
        ];
        let colorIndex = 0;
        rankingBatches.forEach((batch, batchIdx) => {
            if (batch.details && batch.details.length > 0) {
                batch.details.forEach((detail, idx) => {
                    labels.push((batch.nama_sesi || 'Batch ' + (batchIdx+1)) + ' - ' + (detail.proyek || 'Proyek'));
                    data.push(detail.final_maut_score);
                    backgroundColors.push(colorPalette[colorIndex % colorPalette.length]);
                    colorIndex++;
                });
            }
        });
        if (labels.length > 0) {
            const ctx = document.getElementById('rankingBarChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Skor Proyek',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Skor: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0,
                                font: { size: 12 }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Skor Akhir MAUT'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
