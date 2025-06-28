<x-app-layout>
    <x-slot name="title">
        HSE Awards | Create Sub-Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Sub-Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <form action="{{ route('subkriterias.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="kriteria_id" class="block text-sm font-medium text-gray-700">Pilih Kriteria</label>
                            <select name="kriteria_id" id="kriteria_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($kriterias as $kriteria)
                                    <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="kode_sub_kriteria" class="block text-sm font-medium text-gray-700">Kode Sub-Kriteria</label>
                            <input type="text" name="kode_sub_kriteria" id="kode_sub_kriteria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100 cursor-not-allowed" value="{{ $nextKode }}" readonly>
                        </div>

                        <div>
                            <label for="nama_sub_kriteria" class="block text-sm font-medium text-gray-700">Nama Sub-Kriteria</label>
                            <input type="text" name="nama_sub_kriteria" id="nama_sub_kriteria" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label for="keterangan_sub_kriteria" class="block text-sm font-medium text-gray-700">Keterangan Sub-Kriteria</label>
                            <input type="text" name="keterangan_sub_kriteria" id="keterangan_sub_kriteria" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="nilai_sub_kriteria" class="block text-sm font-medium text-gray-700">Nilai Sub-Kriteria</label>
                            <input type="text" name="nilai_sub_kriteria" id="nilai_sub_kriteria" value="{{ $nextNilai }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100 cursor-not-allowed">
                        </div>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('subkriterias.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kriteriaSelect = document.getElementById('kriteria_id');
    const kodeInput = document.getElementById('kode_sub_kriteria');
    const nilaiInput = document.getElementById('nilai_sub_kriteria');
    kriteriaSelect.addEventListener('change', function() {
        const kriteriaId = this.value;
        fetch(`/subkriterias/next-kode?kriteria_id=${kriteriaId}`)
            .then(res => res.json())
            .then(data => {
                kodeInput.value = data.kode;
            });
        fetch(`/subkriterias/next-nilai?kriteria_id=${kriteriaId}`)
            .then(res => res.json())
            .then(data => {
                nilaiInput.value = data.nilai;
            });
    });
});
</script>