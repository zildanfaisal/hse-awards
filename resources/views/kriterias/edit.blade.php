<x-app-layout>
    <x-slot name="title">
        HSE Awards | Edit Kriteria
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 font-medium text-sm text-red-600">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <form action="{{ route('kriterias.update', $kriteria->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="kode_kriteria" class="block text-sm font-medium text-gray-700">Kode Kriteria</label>
                            @php
                                $readonly = (!Auth::user()->can('kriteria.edit') && Auth::user()->can('kriteria.input_bobot')) ? 'disabled style="background:#f3f4f6;cursor:not-allowed"' : '';
                                $canEdit = Auth::user()->can('kriteria.edit');
                            @endphp
                            <input type="text" name="kode_kriteria" id="kode_kriteria" value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100 cursor-not-allowed" {!! $readonly !!}>
                        </div>
                        <div>
                            <label for="nama_kriteria" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" id="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {!! $readonly !!}>
                        </div>
                        
                        <div>
                            <label for="keterangan_kriteria" class="block text-sm font-medium text-gray-700">Keterangan Kriteria</label>
                            <textarea name="keterangan_kriteria" id="keterangan_kriteria" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {!! $readonly !!}>{{ old('keterangan_kriteria', $kriteria->keterangan_kriteria) }}</textarea>
                        </div>

                        <div class="hidden">
                            <label for="tipe_kriteria" class="block text-sm font-medium text-gray-700">Tipe Kriteria</label>
                            <select name="tipe_kriteria" id="tipe_kriteria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {!! $readonly !!}>
                                <option value="benefit" {{ old('tipe_kriteria', $kriteria->tipe_kriteria) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('tipe_kriteria', $kriteria->tipe_kriteria) == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div>

                        <div>
                            <label for="bobot" class="block text-sm font-medium text-gray-700">Bobot</label>
                            @php
                                $bobotReadonly = (!Auth::user()->can('kriteria.input_bobot')) ? 'disabled readonly style="background:#f3f4f6;cursor:not-allowed"' : '';
                            @endphp
                            <input type="text" name="bobot" id="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {!! $bobotReadonly !!}>
                        </div>

                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" id="tahun" min="2020" max="2100" value="{{ old('tahun', $kriteria->tahun) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('kriterias.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            @if($canEdit || Auth::user()->can('kriteria.input_bobot'))
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan Perubahan</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>