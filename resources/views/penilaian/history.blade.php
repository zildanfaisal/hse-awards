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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dihitung Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dihitung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($rankingBatches as $batch)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->nama_sesi ?? 'Tanpa Nama Sesi' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->calculated_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('awards.history.detail', $batch->id) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat ranking yang tersimpan.</td>
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
</x-app-layout>