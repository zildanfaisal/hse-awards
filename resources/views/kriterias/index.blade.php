<x-app-layout>
    <x-slot name="title">
        HSE Awards | Data Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kriteria') }}
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
                @can('kriteria.create')
                    <a href="{{ route('kriterias.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Tambah Kriteria
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Kode Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Keterangan Kriteria</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Bobot</th>
                            @if(
                                Auth::user()->can('kriteria.edit') ||
                                Auth::user()->can('kriteria.input_bobot') ||
                                Auth::user()->can('kriteria.delete')
                            )
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @foreach ($kriterias as $kriteria)
                        <tr class="hover:bg-blue-50 transition text-center align-middle">
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $kriteria->kode_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-left align-middle">{{ $kriteria->nama_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $kriteria->keterangan_kriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $kriteria->bobot }}</td>
                            @if(
                                Auth::user()->can('kriteria.edit') ||
                                Auth::user()->can('kriteria.input_bobot') ||
                                Auth::user()->can('kriteria.delete')
                            )
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <div class="flex justify-center items-center space-x-2">
                                    @if(Auth::user()->can('kriteria.edit') || Auth::user()->can('kriteria.input_bobot'))
                                        <a href="{{ route('kriterias.edit', $kriteria->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    @can('kriteria.delete')
                                    <form id="delete-form-{{ $kriteria->id }}" action="{{ route('kriterias.destroy', $kriteria->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete-kriteria text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus" data-id="{{ $kriteria->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="5 : 5" class="px-6 py-4 font-semibold text-right text-gray-700">Total Bobot:</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">
                                {{ number_format($total_bobot, 2) }}
                                @if($total_bobot >= 1)
                                    <span class="text-red-600 font-bold">*</span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete-kriteria').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin hapus kriteria ini?',
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
