{{-- <x-app-layout>
    <x-slot name="title">
        HSE Awards | Dashboard
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Box Data Proyek -->
                <a href="{{ route('proyeks.index') }}" class="block hover:bg-blue-50 transition duration-150 ease-in-out">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Data Proyek</h3>
                                <p class="text-2xl font-bold">{{ $totalProyek }} Proyek</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Box Data Kriteria -->
                <a href="{{ route('kriterias.index') }}" class="block hover:bg-blue-50 transition duration-150 ease-in-out">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Data Kriteria</h3>
                                <p class="text-2xl font-bold">{{ $totalKriteria }} Kriteria</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Box Data Sub Kriteria -->
                <a href="{{ route('subkriterias.index') }}" class="block hover:bg-blue-50 transition duration-150 ease-in-out">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Data Sub Kriteria</h3>
                                <p class="text-2xl font-bold">{{ $totalSubKriteria }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tabel Data Proyek -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentProyek as $proyek)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->manajer_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->jenis_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->lokasi_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('proyeks.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('proyeks.destroy', $proyek->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
