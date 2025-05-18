<x-app-layout>
    <x-slot name="title">
        HSE Awards | Data Sub-Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Sub-Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('subkriterias.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Tambah Sub-Kriteria
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sub-Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan Sub-Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($subkriterias as $sub)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->nama_sub_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->keterangan_sub_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->nilai_sub_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->kriteria->nama_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('subkriterias.edit', $sub->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('subkriterias.destroy', $sub->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?')">
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
