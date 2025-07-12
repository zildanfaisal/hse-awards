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
                @can('data_proyek')
                    <a href="{{ route('proyeks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Proyek
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Manajer Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Jenis Proyek</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Lokasi Proyek</th>
                            @can('data_proyek')
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @foreach ($proyeks as $proyek)
                        <tr class="hover:bg-blue-50 transition text-center align-middle">
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->manajerProyek ? $proyek->manajerProyek->nama_manajer : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->jenisProyek ? $proyek->jenisProyek->nama_jenis : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $proyek->lokasi_proyek }}</td>
                            @can('data_proyek')
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <div class="flex justify-center items-center space-x-2">
                                    @can('data_proyek')
                                        <a href="{{ route('proyeks.edit', $proyek->id) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    @endcan
                                    <form id="delete-form-{{ $proyek->id }}" action="{{ route('proyeks.destroy', $proyek->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete-proyek text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus" data-id="{{ $proyek->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filter-tahun').addEventListener('change', function() {
        document.getElementById('filter-tahun-form').submit();
    });
    document.querySelectorAll('.btn-delete-proyek').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin hapus proyek ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
});
</script>
