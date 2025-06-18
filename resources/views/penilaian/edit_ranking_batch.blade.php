<x-app-layout>
    <x-slot name="title">Edit Riwayat Ranking</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Riwayat Ranking
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6">
                <form action="{{ route('awards.history.update', $rankingBatch->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi Ranking</label>
                        <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi', $rankingBatch->nama_sesi) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan/Kesimpulan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('catatan', $rankingBatch->catatan) }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('awards.history') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 