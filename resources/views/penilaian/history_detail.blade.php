<x-app-layout>
    <x-slot name="title">HSE Awards | Detail Ranking: {{ $rankingBatch->nama_sesi ?? 'Tanpa Nama Sesi' }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Hasil Ranking: ') }} {{ $rankingBatch->nama_sesi ?? 'Tanpa Nama Sesi' }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-2"><strong>Dihitung Oleh:</strong> {{ $rankingBatch->user->name ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Tanggal Dihitung:</strong> {{ $rankingBatch->calculated_at->format('d M Y H:i') }}</p>
                @if ($rankingBatch->catatan)
                    <p class="mb-4"><strong>Catatan/Kesimpulan:</strong> {{ $rankingBatch->catatan }}</p>
                @endif

                <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4 mt-6">Detail Peringkat Proyek:</h3>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor MAUT</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($rankedDetails as $detail)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->rank }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek->nama_proyek ?? 'Proyek Dihapus' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->proyek->manajer_proyek ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($detail->final_maut_score, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-start">
                    <a href="{{ route('awards.history') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Kembali ke Riwayat Ranking</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>