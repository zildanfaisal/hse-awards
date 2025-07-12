<x-app-layout>
    <x-slot name="title">Manajemen Periode HSE Awards</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Periode HSE Awards</h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8 mb-6">
                <form action="{{ route('periodes.store') }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <div>
                        <label for="nama_periode" class="block text-sm font-medium text-gray-700">Nama Periode (misal: 2025)</label>
                        <input type="text" name="nama_periode" id="nama_periode" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Tambah Periode</button>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Daftar Periode</h3>
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Periode</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($periodes as $periode)
                        <tr>
                            <td class="px-6 py-4 text-center align-middle">{{ $periode->nama_periode }}</td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if($periode->is_active)
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center align-middle">
                                @if(!$periode->is_active)
                                <form action="{{ route('periodes.setActive', $periode->id) }}" method="POST" onsubmit="return confirm('Set periode ini sebagai aktif?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-700 text-white text-xs font-semibold rounded">Set Aktif</button>
                                </form>
                                @else
                                    <span class="text-blue-600 font-semibold">Periode Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 