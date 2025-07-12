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

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <form id="filter-tahun-form" method="GET" action="">
                        <label for="filter-tahun" class="mr-2 font-medium text-gray-700">Tahun:</label>
                        <select name="tahun" id="filter-tahun" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $tahunDipilih == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @foreach ($proyeks as $proyek)
                        <tr class="hover:bg-blue-50 transition text-center align-middle">
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                {{ $proyek->kode_proyek }}
                                @if(App\Models\Penilaian::where('proyek_id', $proyek->id)->exists())
                                    <svg class="inline w-5 h-5 text-green-500 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                {{ $proyek->nama_proyek }}
                                @if(App\Models\Penilaian::where('proyek_id', $proyek->id)->exists())
                                    <svg class="inline w-5 h-5 text-green-500 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('penilaian.create_edit', $proyek->id) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors" title="{{ App\Models\Penilaian::where('proyek_id', $proyek->id)->exists() ? 'Edit Nilai' : 'Input Nilai' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 block">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    @if(App\Models\Penilaian::where('proyek_id', $proyek->id)->exists())
                                    <form id="delete-form-{{ $proyek->id }}" action="{{ route('penilaian.destroy', $proyek->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button onclick="confirmDelete({{ $proyek->id }})" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmDelete(proyekId) {
        Swal.fire({
            title: 'Yakin hapus nilai?',
            text: "Nilai untuk proyek ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + proyekId).submit();
            }
        })
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('filter-tahun').addEventListener('change', function() {
            document.getElementById('filter-tahun-form').submit();
        });
    });
</script>