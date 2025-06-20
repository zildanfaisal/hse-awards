<x-app-layout>
    <x-slot name="title">HSE Awards | Penilaian Proyek</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Penilaian Proyek') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($proyeks as $proyek)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('penilaian.create_edit', $proyek->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                    {{ App\Models\Penilaian::where('proyek_id', $proyek->id)->exists() ? 'Edit Nilai' : 'Input Nilai' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>