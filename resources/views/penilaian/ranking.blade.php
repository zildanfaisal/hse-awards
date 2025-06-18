<x-app-layout>
    <x-slot name="title">HSE Awards | Hasil Ranking</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Hasil Ranking Proyek HSE Awards') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manajer Proyek</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor MAUT</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $rank = 1; @endphp
                        @forelse ($rankedProyeks as $proyek)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $rank++ }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kode_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->manajer_proyek }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($proyek->normalized_score, 6) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada proyek yang dinilai atau data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($rankedProyeks->isNotEmpty())
                    <form action="{{ route('penilaian.save_ranking') }}" method="POST" class="mt-4 p-4 border rounded-md">
                        @csrf
                        <h4 class="font-semibold mb-2">Simpan Hasil Ranking Ini:</h4>
                        <div class="mb-3">
                            <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi Ranking (Opsional):</label>
                            <input type="text" name="nama_sesi" id="nama_sesi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Ranking HSE Awards Periode Juni 2025">
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan/Kesimpulan (Opsional):</label>
                            <textarea name="catatan" id="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Tambahkan kesimpulan atau catatan penting untuk sesi ranking ini."></textarea>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Simpan Ranking Final</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>