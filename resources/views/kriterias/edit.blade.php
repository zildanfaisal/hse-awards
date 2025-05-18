<x-app-layout>
    <x-slot name="title">
        HSE Awards | Edit Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('kriterias.update', $kriteria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="nama_kriteria" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" id="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="keterangan_kriteria" class="block text-sm font-medium text-gray-700">Keterangan Kriteria</label>
                        <input type="text" name="keterangan_kriteria" id="keterangan_kriteria" value="{{ old('keterangan_kriteria', $kriteria->keterangan_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tipe_kriteria" class="block text-sm font-medium text-gray-700">Tipe Kriteria</label>
                        <select name="tipe_kriteria" id="tipe_kriteria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="benefit" {{ old('tipe_kriteria', $kriteria->tipe_kriteria ?? '') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('tipe_kriteria', $kriteria->tipe_kriteria ?? '') == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                    </div>

                    <div>
                        <label for="bobot" class="block text-sm font-medium text-gray-700">Bobot</label>
                        <input type="text" name="bobot" id="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('kriterias.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>