<x-app-layout>
    <x-slot name="title">HSE Awards | Riwayat Ranking</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Hasil Ranking HSE Awards') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">{{ session('success') }}</div>
            @endif

            @can('laporan')
            <div class="flex justify-start mb-2">
                <a href="{{ route('awards.history.export_pdf') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow text-sm font-semibold">
                    Export PDF
                </a>
            </div>
            @endcan

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">No</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Nama Sesi</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Pemenang</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Dihitung Oleh</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Tanggal Dihitung</th>
                            @can('penilaian')
                                <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center align-middle">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-center">
                        @forelse ($rankingBatches as $batch)
                        <tr class="hover:bg-blue-50 transition cursor-pointer text-center align-middle" onclick="window.location='{{ route('awards.history.detail', $batch->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch->nama_sesi ?? 'Tanpa Nama Sesi' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                {{ optional($batch->details->where('rank', 1)->first())->proyek->nama_proyek ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">{{ $batch->calculated_at->format('d M Y') }}</td>
                            @can('penilaian')
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle" onclick="event.stopPropagation();">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('awards.history.edit', $batch->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form id="delete-form-{{ $batch->id }}" action="{{ route('awards.history.destroy', $batch->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $batch->id }})" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors flex justify-center items-center" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->hasPermissionTo('penilaian') ? 5 : 4 }}" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat ranking yang tersimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $rankingBatches->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(batchId) {
            Swal.fire({
                title: 'Yakin hapus riwayat ini?',
                text: "Anda tidak akan bisa mengembalikannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + batchId).submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>