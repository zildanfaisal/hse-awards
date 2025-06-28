<x-app-layout>
    <x-slot name="title">HSE Awards | Edit Jenis Proyek</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Jenis Proyek</h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <form action="{{ route('jenis-proyeks.update', $jenis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="kode_jenis" class="block text-sm font-medium text-gray-700">Kode Jenis</label>
                            <input type="text" name="kode_jenis" id="kode_jenis" value="{{ old('kode_jenis', $jenis->kode_jenis) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="nama_jenis" class="block text-sm font-medium text-gray-700">Nama Jenis</label>
                            <input type="text" name="nama_jenis" id="nama_jenis" value="{{ old('nama_jenis', $jenis->nama_jenis) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end pt-4">
                            <a href="{{ route('jenis-proyeks.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 