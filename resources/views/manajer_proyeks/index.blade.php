<x-app-layout>
    <x-slot name="title">HSE Awards | Data Manajer Proyek</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Manajer Proyek</h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                @can('data_manajer_proyek')
                <a href="{{ route('manajer-proyeks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Tambah Manajer</a>
                @endcan
            </div>
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-gray-200 rounded-2xl overflow-hidden">
                        <thead class="bg-gray-50 text-center">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Manajer</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Manajer</th>
                                @can('data_manajer_proyek')
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-center">
                            @foreach ($manajers as $manajer)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $manajer->kode_manajer }}</td>
                                <td class="px-6 py-4">{{ $manajer->nama_manajer }}</td>
                                @can('data_manajer_proyek')
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('manajer-proyeks.edit', $manajer->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $manajer->id }}" action="{{ route('manajer-proyeks.destroy', $manajer->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete-manajer text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus" data-id="{{ $manajer->id }}">
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
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete-manajer').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin hapus manajer ini?',
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