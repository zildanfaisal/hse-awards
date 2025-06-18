<x-app-layout>
    <x-slot name="title">
        HSE Awards | Data Proyek
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Proyek') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                @if(Auth::user()->role === 'super-admin')
                    <a href="{{ route('proyeks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Proyek
                    </a>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jenis Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Lokasi Proyek</th>
                            @if(Auth::user()->role === 'super-admin')
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($proyeks as $proyek)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->manajer_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                    {{
                                        $proyek->jenis_proyek === 'EPC' ? 'bg-blue-100 text-blue-700' :
                                        ($proyek->jenis_proyek === 'Maintenance' ? 'bg-green-100 text-green-700' :
                                        'bg-purple-100 text-purple-700')
                                    }}
                                ">
                                    {{ $proyek->jenis_proyek }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->lokasi_proyek }}</td>
                            @if(Auth::user()->role === 'super-admin')
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('proyeks.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                <form action="{{ route('proyeks.destroy', $proyek->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2 font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
