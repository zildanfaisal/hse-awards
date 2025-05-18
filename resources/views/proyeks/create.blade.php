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

            <form action="{{ route('proyeks.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="kode_proyek" class="block text-sm font-medium text-gray-700">Kode Proyek</label>
                        <input type="text" name="kode_proyek" id="kode_proyek" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="nama_proyek" class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                        <input type="text" name="nama_proyek" id="nama_proyek" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="manajer_proyek" class="block text-sm font-medium text-gray-700">Manajer Proyek</label>
                        <input type="text" name="manajer_proyek" id="manajer_proyek" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="jenis_proyek" class="block text-sm font-medium text-gray-700">Jenis Proyek</label>
                        <input type="text" name="jenis_proyek" id="jenis_proyek" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="lokasi_proyek" class="block text-sm font-medium text-gray-700">Lokasi Proyek</label>
                        <textarea name="lokasi_proyek" id="lokasi_proyek" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>