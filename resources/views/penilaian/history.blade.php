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

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 rounded-2xl overflow-hidden">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dihitung Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Dihitung</th>
                            @if(Auth::user()->role === 'super-admin')
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($rankingBatches as $batch)
                        <tr class="hover:bg-blue-50 transition cursor-pointer" onclick="window.location='{{ route('awards.history.detail', $batch->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->nama_sesi ?? 'Tanpa Nama Sesi' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $batch->calculated_at->format('d M Y H:i') }}</td>
                            @if(Auth::user()->role === 'super-admin')
                            <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation();">
                                <form action="{{ route('awards.history.destroy', $batch->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus riwayat ranking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'super-admin' ? 4 : 3 }}" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat ranking yang tersimpan.</td>
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