<x-app-layout>
    <x-slot name="title">
        HSE Awards | Data Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kriteria') }}
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
                @if(Auth::user()->role === 'super-admin')
                    <a href="{{ route('kriterias.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Kriteria
                    </a>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Keterangan Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Bobot</th>
                            @if(Auth::user()->role === 'super-admin')
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($kriterias as $kriteria)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->nama_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->keterangan_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->bobot }}</td>
                            @if(Auth::user()->role === 'super-admin')
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('kriterias.edit', $kriteria->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                <form action="{{ route('kriterias.destroy', $kriteria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2 font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-4 font-semibold text-right text-gray-700">Total Bobot:</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">
                                {{ number_format($total_bobot, 2) }}
                                @if($total_bobot >= 1)
                                    <span class="text-red-600 font-bold">*</span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
