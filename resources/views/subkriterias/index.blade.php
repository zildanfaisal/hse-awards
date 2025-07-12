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

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <form id="filter-tahun-form" method="GET" action="">
                        <label for="filter-tahun" class="mr-2 font-medium text-gray-700">Tahun:</label>
                        <select name="tahun" id="filter-tahun" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $tahunDipilih == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @can('sub_kriteria.create')
                    <a href="{{ route('subkriterias.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Sub-Kriteria
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Sub-Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Sub-Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Keterangan Sub-Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nilai</th>
                            @if(
                                Auth::user()->can('sub_kriteria.edit') ||
                                Auth::user()->can('sub_kriteria.input_bobot') ||
                                Auth::user()->can('sub_kriteria.delete')
                            )
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @foreach ($groupSubKriterias as $kriteriaId => $subkriteriaGroup)
                            @php
                                $kriteria = $kriterias[$kriteriaId] ?? null;
                            @endphp
                            <tbody x-data="{ open: false }" class="border-t border-gray-200 text-center align-middle">
                                <tr class="bg-gray-100 cursor-pointer hover:bg-blue-100 transition text-center align-middle" @click="open = !open">
                                    <td colspan="{{ (Auth::user()->can('sub_kriteria.edit') || Auth::user()->can('sub_kriteria.input_bobot') || Auth::user()->can('sub_kriteria.delete')) ? 5 : 4 }}" class="px-6 py-4 font-semibold text-gray-700 text-center align-middle">
                                        <div class="flex items-center justify-between">
                                            @if($kriteria)
                                                <span class="font-bold">[{{ $kriteria->kode_kriteria }}]</span> {{ $kriteria->nama_kriteria }} (Bobot: {{ $kriteria->bobot }})
                                            @else
                                                <span class="text-red-500">Kriteria tidak ditemukan (ID: {{ $kriteriaId }})</span>
                                            @endif
                                            <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($subkriteriaGroup as $sub)
                                <tr x-show="open" x-cloak class="hover:bg-blue-50 transition text-center align-middle">
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $sub->kode_sub_kriteria }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $sub->nama_sub_kriteria }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $sub->keterangan_sub_kriteria }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $sub->nilai_sub_kriteria }}</td>
                                    @if(
                                        Auth::user()->can('sub_kriteria.edit') ||
                                        Auth::user()->can('sub_kriteria.input_bobot') ||
                                        Auth::user()->can('sub_kriteria.delete')
                                    )
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                        <div class="flex justify-center items-center space-x-2">
                                            @if(Auth::user()->can('sub_kriteria.edit') || Auth::user()->can('sub_kriteria.input_bobot'))
                                                <a href="{{ route('subkriterias.edit', $sub->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            @can('sub_kriteria.delete')
                                                <form id="delete-form-{{ $sub->id }}" action="{{ route('subkriterias.destroy', $sub->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete-subkriteria text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus" data-id="{{ $sub->id }}">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filter-tahun').addEventListener('change', function() {
        document.getElementById('filter-tahun-form').submit();
    });
    document.querySelectorAll('.btn-delete-subkriteria').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin hapus sub-kriteria ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
});
</script>
