<x-app-layout>
    <x-slot name="title">HSE Awards | {{ isset($nilaiTersimpan) && !empty($nilaiTersimpan) ? 'Edit' : 'Input' }} Nilai Proyek {{ $proyek->nama_proyek }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Penilaian Proyek') }} - {{ $proyek->nama_proyek }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penilaian.store_update', $proyek->id) }}" method="POST">
                @csrf
                <h3>Kriteria Penilaian:</h3>
                @foreach($kriterias as $kriteria)
                    <div class="mb-4">
                        <label for="kriteria_{{ $kriteria->id }}" class="block text-sm font-medium text-gray-700">
                            {{ $kriteria->nama_kriteria }} (Bobot: {{ $kriteria->bobot }})
                        </label>
                        <select name="kriteria_{{ $kriteria->id }}" id="kriteria_{{ $kriteria->id }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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

                <div class="flex justify-end mt-6">
                    <a href="{{ route('penilaian.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Simpan Penilaian</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>