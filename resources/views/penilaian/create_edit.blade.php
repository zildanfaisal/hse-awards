<x-app-layout>
    <x-slot name="title">HSE Awards | {{ isset($nilaiTersimpan) && !empty($nilaiTersimpan) ? 'Edit' : 'Input' }} Nilai Proyek {{ $proyek->nama_proyek }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Penilaian Proyek') }} - {{ $proyek->nama_proyek }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 text-red-700 border border-red-200 p-4 rounded-lg">
                        <p class="font-bold">Error!</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('penilaian.store_update', $proyek->id) }}" method="POST">
                    @csrf
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Kriteria Penilaian:</h3>
                    
                    <div class="mt-4 space-y-4">
                        @foreach($kriterias as $kriteria)
                            <div>
                                <label for="kriteria_{{ $kriteria->id }}" class="block text-sm font-medium text-gray-700">
                                    [{{ $kriteria->kode_kriteria }}] {{ $kriteria->nama_kriteria }} <span class="text-xs text-gray-500">(Bobot: {{ $kriteria->bobot }})</span>
                                </label>
                                <select name="kriteria_{{ $kriteria->id }}" id="kriteria_{{ $kriteria->id }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Sub-Kriteria</option>
                                    @foreach($kriteria->subKriterias as $subKriteria)
                                        <option value="{{ $subKriteria->id }}"
                                            {{ old('kriteria_' . $kriteria->id, $nilaiTersimpan[$kriteria->id] ?? '') == $subKriteria->id ? 'selected' : '' }}>
                                            {{ $subKriteria->nama_sub_kriteria }} (Nilai: {{ $subKriteria->nilai_sub_kriteria }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end pt-6">
                        <a href="{{ route('penilaian.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan Penilaian</button>
                    </div>
                </form>
                <div class="flex justify-between mt-6">
                    <a href="{{ $prevProyekId ? route('penilaian.create_edit', $prevProyekId) : '#' }}" class="px-4 py-2 rounded-md text-sm font-medium border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 {{ !$prevProyekId ? 'opacity-50 pointer-events-none' : '' }}">&larr; Sebelumnya</a>
                    <a href="{{ $nextProyekId ? route('penilaian.create_edit', $nextProyekId) : '#' }}" class="px-4 py-2 rounded-md text-sm font-medium border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 {{ !$nextProyekId ? 'opacity-50 pointer-events-none' : '' }}">Berikutnya &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>