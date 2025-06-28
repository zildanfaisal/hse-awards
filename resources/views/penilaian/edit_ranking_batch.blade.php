<x-app-layout>
    <x-slot name="title">Edit Riwayat Ranking</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Riwayat Ranking
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-8">
                <form action="{{ route('awards.history.update', $rankingBatch->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label for="nama_sesi" class="block text-sm font-medium text-gray-700">Nama Sesi Ranking</label>
                            <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi', $rankingBatch->nama_sesi) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan/Kesimpulan</label>
                            <textarea name="catatan" id="catatan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('catatan', $rankingBatch->catatan) }}</textarea>
                        </div>

                        <div>
                            <label for="calculated_at" class="block text-sm font-medium text-gray-700">Tanggal Ranking</label>
                            <input type="datetime-local" name="calculated_at" id="calculated_at" value="{{ old('calculated_at', $rankingBatch->calculated_at ? $rankingBatch->calculated_at->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Dihitung Oleh</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $rankingBatch->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end items-center pt-6 space-x-3">
                        <a href="{{ route('awards.history') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 