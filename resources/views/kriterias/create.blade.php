<x-app-layout>
    <x-slot name="title">
        HSE Awards | Create Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <form action="{{ route('kriterias.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="kode_kriteria" class="block text-sm font-medium text-gray-700">Kode Kriteria</label>
                            <input type="text" name="kode_kriteria" id="kode_kriteria" value="{{ isset($nextKodeKriteria) ? $nextKodeKriteria : '' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="nama_kriteria" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" id="nama_kriteria" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label for="keterangan_kriteria" class="block text-sm font-medium text-gray-700">Keterangan Kriteria</label>
                            <input type="text" name="keterangan_kriteria" id="keterangan_kriteria" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="tipe_kriteria" class="block text-sm font-medium text-gray-700">Tipe Kriteria</label>
                            <select name="tipe_kriteria" id="tipe_kriteria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>

                        <div>
                            <label for="bobot" class="block text-sm font-medium text-gray-700">Bobot</label>
                            <input type="text" name="bobot" id="bobot" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('kriterias.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>