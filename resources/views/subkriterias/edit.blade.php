<x-app-layout>
    <x-slot name="title">
        HSE Awards | Edit Sub-Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sub-Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('subkriterias.update', $subkriteria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="kriteria_id" class="block text-sm font-medium text-gray-700">Pilih Kriteria</label>
                        <select name="kriteria_id" id="kriteria_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach($kriterias as $kriteria)
                                <option value="{{ $kriteria->id }}" {{ $kriteria->id == $subkriteria->kriteria_id ? 'selected' : '' }}>
                                    {{ $kriteria->nama_kriteria }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nama_sub_kriteria" class="block text-sm font-medium text-gray-700">Nama Sub-Kriteria</label>
                        <input type="text" name="nama_sub_kriteria" id="nama_sub_kriteria" value="{{ old('nama_sub_kriteria', $subkriteria->nama_sub_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="keterangan_sub_kriteria" class="block text-sm font-medium text-gray-700">Keterangan Sub-Kriteria</label>
                        <input type="text" name="keterangan_sub_kriteria" id="keterangan_sub_kriteria" value="{{ old('keterangan_sub_kriteria', $subkriteria->keterangan_sub_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="nilai_sub_kriteria" class="block text-sm font-medium text-gray-700">Nilai Sub-Kriteria</label>
                        <input type="text" name="nilai_sub_kriteria" id="nilai_sub_kriteria" value="{{ old('nilai_sub_kriteria', $subkriteria->nilai_sub_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('subkriterias.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>