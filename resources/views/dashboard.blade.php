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
                                <p class="text-2xl font-bold text-purple-700">{{ $totalSubKriteria }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-700">Riwayat Ranking Terbaru</h3>
                    <a href="{{ route('awards.history') }}" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Sesi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dihitung Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Dihitung</th>
                                @if(Auth::user()->role === 'super-admin')
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($recentRankingBatches as $batch)
                            <tr class="hover:bg-blue-50 transition cursor-pointer" onclick="window.location='{{ route('awards.history.detail', $batch->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $batch->nama_sesi ?? 'Tanpa Nama Sesi' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $batch->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $batch->calculated_at->format('d M Y H:i') }}</td>
                                @if(Auth::user()->role === 'super-admin')
                                <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation();">
                                    <form action="{{ route('awards.history.destroy', $batch->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus riwayat ranking ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'super-admin' ? 4 : 3 }}" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat ranking yang tersimpan.</td>
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
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jenis Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Lokasi Proyek</th>
                            @if(Auth::user()->role === 'super-admin')
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($recentProyek as $proyek)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->manajer_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                    {{
                                        $proyek->jenis_proyek === 'EPC' ? 'bg-blue-100 text-blue-700' :
                                        ($proyek->jenis_proyek === 'Maintenance' ? 'bg-green-100 text-green-700' :
                                        'bg-purple-100 text-purple-700')
                                    }}
                                ">
                                    {{ $proyek->jenis_proyek }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->lokasi_proyek }}</td>
                            @if(Auth::user()->role === 'super-admin')
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('proyeks.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                <form action="{{ route('proyeks.destroy', $proyek->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2 font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
