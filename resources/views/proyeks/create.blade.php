<x-app-layout>
    <x-slot name="title">
        HSE Awards | Create Proyek
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Proyek') }}
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
                <form action="{{ route('proyeks.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="kode_proyek" class="block text-sm font-medium text-gray-700">Kode Proyek</label>
                            <input type="text" name="kode_proyek" id="kode_proyek" value="{{ $nextKode }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100" readonly>
                        </div>

                        <div>
                            <label for="nama_proyek" class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                            <input type="text" name="nama_proyek" id="nama_proyek" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="manajer_proyek_id" class="block text-sm font-medium text-gray-700">Manajer Proyek</label>
                            <select name="manajer_proyek_id" id="manajer_proyek_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Manajer</option>
                                @foreach($manajers as $manajer)
                                    <option value="{{ $manajer->id }}">{{ $manajer->kode_manajer }} - {{ $manajer->nama_manajer }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="jenis_proyek_id" class="block text-sm font-medium text-gray-700">Jenis Proyek</label>
                            <select name="jenis_proyek_id" id="jenis_proyek_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Jenis</option>
                                @foreach($jenisList as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->kode_jenis }} - {{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="lokasi_proyek" class="block text-sm font-medium text-gray-700">Lokasi Proyek</label>
                            <textarea name="lokasi_proyek" id="lokasi_proyek" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('proyeks.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>